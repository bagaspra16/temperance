<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class MigrateDataFromPostgres extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'migrate:from-postgres 
                            {--host=127.0.0.1 : PostgreSQL host}
                            {--port=5432 : PostgreSQL port}
                            {--database=temperance : PostgreSQL database name}
                            {--username= : PostgreSQL username}
                            {--password= : PostgreSQL password}
                            {--verify : Only verify data counts}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Migrate data from PostgreSQL to MySQL';

    /**
     * PostgreSQL connection
     */
    private $pgsqlConnection;

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Starting PostgreSQL to MySQL data migration...');

        // Setup PostgreSQL connection
        $this->setupPostgresConnection();

        if ($this->option('verify')) {
            $this->verifyMigration();
            return;
        }

        // Confirm before proceeding
        if (!$this->confirm('This will migrate all data from PostgreSQL to MySQL. Continue?')) {
            $this->info('Migration cancelled.');
            return;
        }

        try {
            $this->migrateAll();
            $this->info('Migration completed successfully!');
            $this->verifyMigration();
        } catch (\Exception $e) {
            $this->error('Migration failed: ' . $e->getMessage());
            return 1;
        }

        return 0;
    }

    private function setupPostgresConnection()
    {
        $host = $this->option('host');
        $port = $this->option('port');
        $database = $this->option('database');
        $username = $this->option('username') ?: $this->ask('PostgreSQL username');
        $password = $this->option('password') ?: $this->secret('PostgreSQL password');

        $dsn = "pgsql:host={$host};port={$port};dbname={$database}";
        
        try {
            $this->pgsqlConnection = new \PDO($dsn, $username, $password);
            $this->pgsqlConnection->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
            $this->info('Connected to PostgreSQL successfully.');
        } catch (\PDOException $e) {
            $this->error('Failed to connect to PostgreSQL: ' . $e->getMessage());
            throw $e;
        }
    }

    private function migrateAll()
    {
        $tables = [
            'users' => 'id, name, email, email_verified_at, password, avatar, bio, remember_token, created_at, updated_at, deleted_at',
            'categories' => 'id, name, color, description, user_id, created_at, updated_at, deleted_at',
            'goals' => 'id, title, description, start_date, end_date, priority, status, progress_percent, category_id, user_id, created_at, updated_at, deleted_at',
            'tasks' => 'id, title, description, due_date, priority, status, completed_at, goal_id, user_id, start_time, completed_time, duration_minutes, force_complete_reason, created_at, updated_at, deleted_at',
            'progress' => 'id, note, progress_value, goal_id, task_id, user_id, created_at, updated_at',
            'journals' => 'id, user_id, date, title, content, mood, tags, category, important, created_at, updated_at, deleted_at',
            'achievements' => 'id, user_id, goal_id, title, description, certificate_message, affirmation_message, certificate_number, achievement_date, status, created_at, updated_at, deleted_at'
        ];

        foreach ($tables as $table => $columns) {
            $this->migrateTable($table, $columns);
        }
    }

    private function migrateTable($tableName, $columns)
    {
        $this->info("Migrating {$tableName}...");

        try {
            // Get data from PostgreSQL
            $stmt = $this->pgsqlConnection->query("SELECT {$columns} FROM {$tableName}");
            $records = $stmt->fetchAll(\PDO::FETCH_ASSOC);

            if (empty($records)) {
                $this->warn("No data found in {$tableName}");
                return;
            }

            // Clear existing data in MySQL
            DB::table($tableName)->truncate();

            // Insert data into MySQL
            $columnArray = explode(', ', $columns);
            $placeholders = str_repeat('?,', count($columnArray) - 1) . '?';
            
            $sql = "INSERT INTO {$tableName} ({$columns}) VALUES ({$placeholders})";
            $stmt = DB::getPdo()->prepare($sql);

            $count = 0;
            foreach ($records as $record) {
                $values = array_values($record);
                
                // Handle JSON columns for journals
                if ($tableName === 'journals' && isset($record['tags'])) {
                    $jsonIndex = array_search('tags', $columnArray);
                    if ($jsonIndex !== false && $values[$jsonIndex]) {
                        // Ensure proper JSON format
                        $values[$jsonIndex] = json_encode(json_decode($values[$jsonIndex]));
                    }
                }
                
                $stmt->execute($values);
                $count++;
            }

            $this->info("Migrated {$count} records to {$tableName}");

        } catch (\Exception $e) {
            $this->error("Failed to migrate {$tableName}: " . $e->getMessage());
            throw $e;
        }
    }

    private function verifyMigration()
    {
        $this->info('Verifying migration...');

        $tables = ['users', 'categories', 'goals', 'tasks', 'progress', 'journals', 'achievements'];

        $this->table(
            ['Table', 'PostgreSQL Count', 'MySQL Count', 'Status'],
            collect($tables)->map(function ($table) {
                try {
                    $pgsqlCount = $this->pgsqlConnection->query("SELECT COUNT(*) FROM {$table}")->fetchColumn();
                    $mysqlCount = DB::table($table)->count();
                    $status = $pgsqlCount == $mysqlCount ? '✓ Match' : '✗ Mismatch';
                    
                    return [$table, $pgsqlCount, $mysqlCount, $status];
                } catch (\Exception $e) {
                    return [$table, 'Error', 'Error', '✗ Error: ' . $e->getMessage()];
                }
            })
        );

        // Test relationships
        $this->info('Testing relationships...');
        try {
            $user = DB::table('users')->first();
            if ($user) {
                $categoriesCount = DB::table('categories')->where('user_id', $user->id)->count();
                $goalsCount = DB::table('goals')->where('user_id', $user->id)->count();
                $tasksCount = DB::table('tasks')->where('user_id', $user->id)->count();
                $journalsCount = DB::table('journals')->where('user_id', $user->id)->count();
                
                $this->info("User {$user->name} has: {$categoriesCount} categories, {$goalsCount} goals, {$tasksCount} tasks, {$journalsCount} journals");
            }
        } catch (\Exception $e) {
            $this->warn('Could not test relationships: ' . $e->getMessage());
        }

        // Test JSON columns
        $this->info('Testing JSON columns...');
        try {
            $journalWithTags = DB::table('journals')->whereNotNull('tags')->first();
            if ($journalWithTags) {
                $tags = json_decode($journalWithTags->tags, true);
                $this->info("Journal tags test: " . json_encode($tags));
            }
        } catch (\Exception $e) {
            $this->warn('Could not test JSON columns: ' . $e->getMessage());
        }
    }
}
