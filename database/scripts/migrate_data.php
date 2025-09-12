<?php

/**
 * Script untuk migrasi data dari PostgreSQL ke MySQL
 * 
 * Usage: php database/scripts/migrate_data.php
 */

require_once __DIR__ . '/../../../vendor/autoload.php';

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class DataMigrator
{
    private $pgsqlConnection;
    private $mysqlConnection;
    
    public function __construct()
    {
        // Setup PostgreSQL connection
        $this->pgsqlConnection = new PDO(
            'pgsql:host=127.0.0.1;port=5432;dbname=temperance',
            'your_postgres_username',
            'your_postgres_password'
        );
        
        // Setup MySQL connection
        $this->mysqlConnection = new PDO(
            'mysql:host=127.0.0.1;port=3306;dbname=temperance',
            'root',
            'your_mysql_password'
        );
    }
    
    public function migrateUsers()
    {
        echo "Migrating users...\n";
        
        $stmt = $this->pgsqlConnection->query("SELECT * FROM users");
        $users = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        $mysqlStmt = $this->mysqlConnection->prepare("
            INSERT INTO users (id, name, email, email_verified_at, password, avatar, bio, remember_token, created_at, updated_at, deleted_at) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
        ");
        
        foreach ($users as $user) {
            $mysqlStmt->execute([
                $user['id'],
                $user['name'],
                $user['email'],
                $user['email_verified_at'],
                $user['password'],
                $user['avatar'],
                $user['bio'],
                $user['remember_token'],
                $user['created_at'],
                $user['updated_at'],
                $user['deleted_at']
            ]);
        }
        
        echo "Migrated " . count($users) . " users\n";
    }
    
    public function migrateCategories()
    {
        echo "Migrating categories...\n";
        
        $stmt = $this->pgsqlConnection->query("SELECT * FROM categories");
        $categories = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        $mysqlStmt = $this->mysqlConnection->prepare("
            INSERT INTO categories (id, name, color, description, user_id, created_at, updated_at, deleted_at) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?)
        ");
        
        foreach ($categories as $category) {
            $mysqlStmt->execute([
                $category['id'],
                $category['name'],
                $category['color'],
                $category['description'],
                $category['user_id'],
                $category['created_at'],
                $category['updated_at'],
                $category['deleted_at']
            ]);
        }
        
        echo "Migrated " . count($categories) . " categories\n";
    }
    
    public function migrateGoals()
    {
        echo "Migrating goals...\n";
        
        $stmt = $this->pgsqlConnection->query("SELECT * FROM goals");
        $goals = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        $mysqlStmt = $this->mysqlConnection->prepare("
            INSERT INTO goals (id, title, description, start_date, end_date, priority, status, progress_percent, category_id, user_id, created_at, updated_at, deleted_at) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
        ");
        
        foreach ($goals as $goal) {
            $mysqlStmt->execute([
                $goal['id'],
                $goal['title'],
                $goal['description'],
                $goal['start_date'],
                $goal['end_date'],
                $goal['priority'],
                $goal['status'],
                $goal['progress_percent'],
                $goal['category_id'],
                $goal['user_id'],
                $goal['created_at'],
                $goal['updated_at'],
                $goal['deleted_at']
            ]);
        }
        
        echo "Migrated " . count($goals) . " goals\n";
    }
    
    public function migrateTasks()
    {
        echo "Migrating tasks...\n";
        
        $stmt = $this->pgsqlConnection->query("SELECT * FROM tasks");
        $tasks = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        $mysqlStmt = $this->mysqlConnection->prepare("
            INSERT INTO tasks (id, title, description, due_date, priority, status, completed_at, goal_id, user_id, start_time, completed_time, duration_minutes, force_complete_reason, created_at, updated_at, deleted_at) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
        ");
        
        foreach ($tasks as $task) {
            $mysqlStmt->execute([
                $task['id'],
                $task['title'],
                $task['description'],
                $task['due_date'],
                $task['priority'],
                $task['status'],
                $task['completed_at'],
                $task['goal_id'],
                $task['user_id'],
                $task['start_time'] ?? null,
                $task['completed_time'] ?? null,
                $task['duration_minutes'] ?? null,
                $task['force_complete_reason'] ?? null,
                $task['created_at'],
                $task['updated_at'],
                $task['deleted_at']
            ]);
        }
        
        echo "Migrated " . count($tasks) . " tasks\n";
    }
    
    public function migrateProgress()
    {
        echo "Migrating progress...\n";
        
        $stmt = $this->pgsqlConnection->query("SELECT * FROM progress");
        $progress = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        $mysqlStmt = $this->mysqlConnection->prepare("
            INSERT INTO progress (id, note, progress_value, goal_id, task_id, user_id, created_at, updated_at) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?)
        ");
        
        foreach ($progress as $prog) {
            $mysqlStmt->execute([
                $prog['id'],
                $prog['note'],
                $prog['progress_value'],
                $prog['goal_id'],
                $prog['task_id'],
                $prog['user_id'],
                $prog['created_at'],
                $prog['updated_at']
            ]);
        }
        
        echo "Migrated " . count($progress) . " progress records\n";
    }
    
    public function migrateJournals()
    {
        echo "Migrating journals...\n";
        
        $stmt = $this->pgsqlConnection->query("SELECT * FROM journals");
        $journals = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        $mysqlStmt = $this->mysqlConnection->prepare("
            INSERT INTO journals (id, user_id, date, title, content, mood, tags, category, important, created_at, updated_at, deleted_at) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
        ");
        
        foreach ($journals as $journal) {
            // Convert PostgreSQL JSON to MySQL JSON
            $tags = $journal['tags'] ? json_encode(json_decode($journal['tags'])) : null;
            
            $mysqlStmt->execute([
                $journal['id'],
                $journal['user_id'],
                $journal['date'],
                $journal['title'],
                $journal['content'],
                $journal['mood'],
                $tags,
                $journal['category'],
                $journal['important'],
                $journal['created_at'],
                $journal['updated_at'],
                $journal['deleted_at']
            ]);
        }
        
        echo "Migrated " . count($journals) . " journals\n";
    }
    
    public function migrateAchievements()
    {
        echo "Migrating achievements...\n";
        
        $stmt = $this->pgsqlConnection->query("SELECT * FROM achievements");
        $achievements = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        $mysqlStmt = $this->mysqlConnection->prepare("
            INSERT INTO achievements (id, user_id, goal_id, title, description, certificate_message, affirmation_message, certificate_number, achievement_date, status, created_at, updated_at, deleted_at) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
        ");
        
        foreach ($achievements as $achievement) {
            $mysqlStmt->execute([
                $achievement['id'],
                $achievement['user_id'],
                $achievement['goal_id'],
                $achievement['title'],
                $achievement['description'],
                $achievement['certificate_message'],
                $achievement['affirmation_message'],
                $achievement['certificate_number'],
                $achievement['achievement_date'],
                $achievement['status'],
                $achievement['created_at'],
                $achievement['updated_at'],
                $achievement['deleted_at']
            ]);
        }
        
        echo "Migrated " . count($achievements) . " achievements\n";
    }
    
    public function migrateAll()
    {
        echo "Starting data migration from PostgreSQL to MySQL...\n";
        
        try {
            $this->migrateUsers();
            $this->migrateCategories();
            $this->migrateGoals();
            $this->migrateTasks();
            $this->migrateProgress();
            $this->migrateJournals();
            $this->migrateAchievements();
            
            echo "Migration completed successfully!\n";
            
        } catch (Exception $e) {
            echo "Migration failed: " . $e->getMessage() . "\n";
            throw $e;
        }
    }
    
    public function verifyMigration()
    {
        echo "Verifying migration...\n";
        
        $tables = ['users', 'categories', 'goals', 'tasks', 'progress', 'journals', 'achievements'];
        
        foreach ($tables as $table) {
            $pgsqlCount = $this->pgsqlConnection->query("SELECT COUNT(*) FROM $table")->fetchColumn();
            $mysqlCount = $this->mysqlConnection->query("SELECT COUNT(*) FROM $table")->fetchColumn();
            
            echo "$table: PostgreSQL=$pgsqlCount, MySQL=$mysqlCount " . ($pgsqlCount == $mysqlCount ? "✓" : "✗") . "\n";
        }
    }
}

// Usage
if (php_sapi_name() === 'cli') {
    $migrator = new DataMigrator();
    
    if (isset($argv[1]) && $argv[1] === 'verify') {
        $migrator->verifyMigration();
    } else {
        $migrator->migrateAll();
    }
}
