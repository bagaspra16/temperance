<?php

/**
 * Script untuk testing kompatibilitas MySQL
 * 
 * Usage: php database/scripts/test_mysql_compatibility.php
 */

require_once __DIR__ . '/../../../vendor/autoload.php';

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use App\Models\User;
use App\Models\Category;
use App\Models\Goal;
use App\Models\Task;
use App\Models\Progress;
use App\Models\Journal;
use App\Models\Achievement;

class MySQLCompatibilityTest
{
    private $tests = [];
    private $passed = 0;
    private $failed = 0;

    public function runAllTests()
    {
        echo "=== MySQL Compatibility Tests ===\n\n";

        $this->testDatabaseConnection();
        $this->testUuidGeneration();
        $this->testJsonColumns();
        $this->testDayOfWeekFunction();
        $this->testForeignKeys();
        $this->testIndexes();
        $this->testSoftDeletes();
        $this->testEnumColumns();
        $this->testDateTimeColumns();
        $this->testRelationships();

        $this->printResults();
    }

    private function testDatabaseConnection()
    {
        $this->addTest('Database Connection', function() {
            $connection = DB::connection()->getPdo();
            return $connection !== null;
        });
    }

    private function testUuidGeneration()
    {
        $this->addTest('UUID Generation', function() {
            $user = new User([
                'name' => 'Test User',
                'email' => 'test@example.com',
                'password' => bcrypt('password')
            ]);
            $user->save();
            
            $isUuid = preg_match('/^[0-9a-f]{8}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{12}$/i', $user->id);
            
            // Clean up
            $user->delete();
            
            return $isUuid;
        });
    }

    private function testJsonColumns()
    {
        $this->addTest('JSON Columns', function() {
            $user = User::factory()->create();
            
            $journal = new Journal([
                'user_id' => $user->id,
                'date' => now(),
                'content' => 'Test content',
                'tags' => ['work', 'important', 'test']
            ]);
            $journal->save();
            
            $retrieved = Journal::find($journal->id);
            $isArray = is_array($retrieved->tags);
            $hasCorrectTags = $retrieved->tags === ['work', 'important', 'test'];
            
            // Clean up
            $journal->delete();
            $user->delete();
            
            return $isArray && $hasCorrectTags;
        });
    }

    private function testDayOfWeekFunction()
    {
        $this->addTest('Day of Week Function', function() {
            $user = User::factory()->create();
            
            // Create journals for different days
            $journals = [];
            for ($i = 0; $i < 7; $i++) {
                $journal = new Journal([
                    'user_id' => $user->id,
                    'date' => now()->subDays($i),
                    'content' => "Test content for day {$i}"
                ]);
                $journal->save();
                $journals[] = $journal;
            }
            
            // Test DAYOFWEEK function
            $result = Journal::where('user_id', $user->id)
                           ->selectRaw('DAYOFWEEK(date) as day_of_week, COUNT(*) as count')
                           ->groupBy('day_of_week')
                           ->get();
            
            $hasResults = $result->count() > 0;
            $validDayNumbers = $result->every(function($item) {
                return $item->day_of_week >= 1 && $item->day_of_week <= 7;
            });
            
            // Clean up
            foreach ($journals as $journal) {
                $journal->delete();
            }
            $user->delete();
            
            return $hasResults && $validDayNumbers;
        });
    }

    private function testForeignKeys()
    {
        $this->addTest('Foreign Keys', function() {
            $user = User::factory()->create();
            
            $category = new Category([
                'name' => 'Test Category',
                'user_id' => $user->id
            ]);
            $category->save();
            
            $goal = new Goal([
                'title' => 'Test Goal',
                'start_date' => now(),
                'end_date' => now()->addDays(30),
                'category_id' => $category->id,
                'user_id' => $user->id
            ]);
            $goal->save();
            
            $task = new Task([
                'title' => 'Test Task',
                'goal_id' => $goal->id,
                'user_id' => $user->id
            ]);
            $task->save();
            
            // Test relationships
            $goalBelongsToCategory = $goal->category->id === $category->id;
            $taskBelongsToGoal = $task->goal->id === $goal->id;
            $categoryHasGoal = $category->goals->contains($goal->id);
            
            // Clean up
            $task->delete();
            $goal->delete();
            $category->delete();
            $user->delete();
            
            return $goalBelongsToCategory && $taskBelongsToGoal && $categoryHasGoal;
        });
    }

    private function testIndexes()
    {
        $this->addTest('Indexes', function() {
            $indexes = DB::select("SHOW INDEX FROM users");
            $hasIndexes = count($indexes) > 0;
            
            $emailIndex = collect($indexes)->contains(function($index) {
                return $index->Column_name === 'email';
            });
            
            return $hasIndexes && $emailIndex;
        });
    }

    private function testSoftDeletes()
    {
        $this->addTest('Soft Deletes', function() {
            $user = User::factory()->create();
            $userId = $user->id;
            
            $user->delete();
            
            $deletedUser = User::withTrashed()->find($userId);
            $softDeleted = $deletedUser && $deletedUser->trashed();
            
            // Clean up
            $deletedUser->forceDelete();
            
            return $softDeleted;
        });
    }

    private function testEnumColumns()
    {
        $this->addTest('Enum Columns', function() {
            $user = User::factory()->create();
            
            $goal = new Goal([
                'title' => 'Test Goal',
                'start_date' => now(),
                'end_date' => now()->addDays(30),
                'priority' => 'high',
                'status' => 'in_progress',
                'user_id' => $user->id
            ]);
            $goal->save();
            
            $task = new Task([
                'title' => 'Test Task',
                'priority' => 'medium',
                'status' => 'pending',
                'goal_id' => $goal->id,
                'user_id' => $user->id
            ]);
            $task->save();
            
            $validPriority = in_array($goal->priority, ['low', 'medium', 'high']);
            $validStatus = in_array($goal->status, ['not_started', 'in_progress', 'completed', 'finished', 'abandoned']);
            $validTaskStatus = in_array($task->status, ['pending', 'in_progress', 'completed']);
            
            // Clean up
            $task->delete();
            $goal->delete();
            $user->delete();
            
            return $validPriority && $validStatus && $validTaskStatus;
        });
    }

    private function testDateTimeColumns()
    {
        $this->addTest('DateTime Columns', function() {
            $user = User::factory()->create();
            
            $task = new Task([
                'title' => 'Test Task',
                'due_date' => now()->addDays(7),
                'start_time' => now(),
                'completed_time' => now()->addHours(2),
                'duration_minutes' => 120,
                'user_id' => $user->id
            ]);
            $task->save();
            
            $retrieved = Task::find($task->id);
            
            $hasDueDate = $retrieved->due_date instanceof \Carbon\Carbon;
            $hasStartTime = $retrieved->start_time instanceof \Carbon\Carbon;
            $hasCompletedTime = $retrieved->completed_time instanceof \Carbon\Carbon;
            $hasDuration = is_int($retrieved->duration_minutes);
            
            // Clean up
            $task->delete();
            $user->delete();
            
            return $hasDueDate && $hasStartTime && $hasCompletedTime && $hasDuration;
        });
    }

    private function testRelationships()
    {
        $this->addTest('Relationships', function() {
            $user = User::factory()->create();
            
            $category = new Category([
                'name' => 'Test Category',
                'user_id' => $user->id
            ]);
            $category->save();
            
            $goal = new Goal([
                'title' => 'Test Goal',
                'start_date' => now(),
                'end_date' => now()->addDays(30),
                'category_id' => $category->id,
                'user_id' => $user->id
            ]);
            $goal->save();
            
            $task = new Task([
                'title' => 'Test Task',
                'goal_id' => $goal->id,
                'user_id' => $user->id
            ]);
            $task->save();
            
            $journal = new Journal([
                'user_id' => $user->id,
                'date' => now(),
                'content' => 'Test content'
            ]);
            $journal->save();
            
            // Test all relationships
            $userHasCategories = $user->categories->count() > 0;
            $userHasGoals = $user->goals->count() > 0;
            $userHasTasks = $user->tasks->count() > 0;
            $userHasJournals = $user->journals->count() > 0;
            $categoryHasGoals = $category->goals->count() > 0;
            $goalHasTasks = $goal->tasks->count() > 0;
            
            // Clean up
            $journal->delete();
            $task->delete();
            $goal->delete();
            $category->delete();
            $user->delete();
            
            return $userHasCategories && $userHasGoals && $userHasTasks && 
                   $userHasJournals && $categoryHasGoals && $goalHasTasks;
        });
    }

    private function addTest($name, $testFunction)
    {
        try {
            $result = $testFunction();
            if ($result) {
                $this->passed++;
                echo "✓ {$name}\n";
            } else {
                $this->failed++;
                echo "✗ {$name}\n";
            }
        } catch (\Exception $e) {
            $this->failed++;
            echo "✗ {$name} - Error: " . $e->getMessage() . "\n";
        }
    }

    private function printResults()
    {
        echo "\n=== Test Results ===\n";
        echo "Passed: {$this->passed}\n";
        echo "Failed: {$this->failed}\n";
        echo "Total: " . ($this->passed + $this->failed) . "\n";
        
        if ($this->failed === 0) {
            echo "\n🎉 All tests passed! MySQL compatibility is confirmed.\n";
        } else {
            echo "\n⚠️  Some tests failed. Please check the issues above.\n";
        }
    }
}

// Run tests if called directly
if (php_sapi_name() === 'cli') {
    $tester = new MySQLCompatibilityTest();
    $tester->runAllTests();
}
