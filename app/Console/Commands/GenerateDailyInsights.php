<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Task;
use App\Models\Category;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class GenerateDailyInsights extends Command
{
    protected $signature = 'insights:generate-daily';
    protected $description = 'Generate daily AI insights for users';

    public function handle()
    {
        $yesterday = Carbon::yesterday();
        $today = Carbon::today();

        // Get all users who have tasks
        $users = DB::table('tasks')
            ->select('user_id')
            ->distinct()
            ->get();

        foreach ($users as $user) {
            // Get user's tasks data
            $tasks = Task::where('user_id', $user->user_id)
                ->with(['category'])
                ->get();

            // Calculate various metrics
            $totalTasks = $tasks->count();
            $completedTasks = $tasks->where('status', 'complete')->count();
            $inProgressTasks = $tasks->where('status', 'in_progress')->count();
            $pendingTasks = $tasks->where('status', 'pending')->count();

            // Get tasks completed yesterday
            $yesterdayCompleted = $tasks->where('status', 'complete')
                ->where('updated_at', '>=', $yesterday)
                ->where('updated_at', '<', $today)
                ->count();

            // Get category distribution
            $categoryDistribution = $tasks->groupBy('category_id')
                ->map(function ($categoryTasks) {
                    return $categoryTasks->count();
                });

            // Get most productive time of day
            $timeDistribution = $tasks->where('status', 'complete')
                ->groupBy(function ($task) {
                    return Carbon::parse($task->updated_at)->format('H');
                })
                ->map(function ($tasks) {
                    return $tasks->count();
                });

            $mostProductiveHour = $timeDistribution->sortDesc()->keys()->first();

            // Calculate average completion time
            $completionTimes = $tasks->where('status', 'complete')
                ->map(function ($task) {
                    return Carbon::parse($task->created_at)
                        ->diffInHours(Carbon::parse($task->updated_at));
                });

            $avgCompletionTime = $completionTimes->avg();

            // Generate insights
            $insights = [
                'daily_summary' => [
                    'completed_yesterday' => $yesterdayCompleted,
                    'completion_rate' => $totalTasks > 0 ? round(($completedTasks / $totalTasks) * 100) : 0,
                    'most_productive_hour' => $mostProductiveHour,
                    'avg_completion_time' => round($avgCompletionTime, 1),
                ],
                'category_insights' => $categoryDistribution->map(function ($count, $categoryId) use ($totalTasks) {
                    $category = Category::find($categoryId);
                    return [
                        'name' => $category->category_type,
                        'percentage' => round(($count / $totalTasks) * 100, 1),
                        'count' => $count
                    ];
                })->values(),
                'productivity_trends' => [
                    'completion_rate' => $totalTasks > 0 ? round(($completedTasks / $totalTasks) * 100) : 0,
                    'in_progress_ratio' => $totalTasks > 0 ? round(($inProgressTasks / $totalTasks) * 100) : 0,
                    'pending_ratio' => $totalTasks > 0 ? round(($pendingTasks / $totalTasks) * 100) : 0,
                ],
                'suggestions' => $this->generateSuggestions([
                    'completion_rate' => $totalTasks > 0 ? round(($completedTasks / $totalTasks) * 100) : 0,
                    'in_progress_ratio' => $totalTasks > 0 ? round(($inProgressTasks / $totalTasks) * 100) : 0,
                    'pending_ratio' => $totalTasks > 0 ? round(($pendingTasks / $totalTasks) * 100) : 0,
                    'avg_completion_time' => $avgCompletionTime,
                    'most_productive_hour' => $mostProductiveHour,
                ])
            ];

            // Store insights in the database
            DB::table('user_insights')->updateOrInsert(
                ['user_id' => $user->user_id, 'date' => $today],
                ['insights' => json_encode($insights)]
            );
        }

        $this->info('Daily insights generated successfully!');
    }

    private function generateSuggestions($metrics)
    {
        $suggestions = [];

        // Completion rate suggestions
        if ($metrics['completion_rate'] < 40) {
            $suggestions[] = "Your task completion rate is low. Consider breaking down larger tasks into smaller, manageable pieces.";
        } elseif ($metrics['completion_rate'] > 80) {
            $suggestions[] = "Great completion rate! Consider setting more challenging goals to maintain momentum.";
        }

        // In-progress tasks suggestions
        if ($metrics['in_progress_ratio'] > 50) {
            $suggestions[] = "You have many tasks in progress. Focus on completing existing tasks before starting new ones.";
        }

        // Pending tasks suggestions
        if ($metrics['pending_ratio'] > 30) {
            $suggestions[] = "High number of pending tasks. Consider prioritizing and scheduling them more effectively.";
        }

        // Time management suggestions
        if ($metrics['avg_completion_time'] > 24) {
            $suggestions[] = "Tasks are taking longer than a day to complete. Consider setting stricter deadlines.";
        }

        // Productivity time suggestions
        if ($metrics['most_productive_hour']) {
            $suggestions[] = "You're most productive around " .
                Carbon::createFromFormat('H', $metrics['most_productive_hour'])->format('g A') .
                ". Schedule important tasks during this time.";
        }

        return $suggestions;
    }
}
