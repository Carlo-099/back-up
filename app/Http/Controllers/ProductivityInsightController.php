<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class ProductivityInsightController extends Controller
{
    public function index()
    {
        $userId = Auth::id();

        // Get task statistics
        $totalTasks = Task::where('user_id', $userId)->count();
        $completedTasks = Task::where('user_id', $userId)->where('status', 'complete')->count();
        $inProgressTasks = Task::where('user_id', $userId)->where('status', 'in_progress')->count();
        $pendingTasks = Task::where('user_id', $userId)->where('status', 'pending')->count();

        // Get category statistics
        $categoryStats = Category::where('user_id', $userId)
            ->withCount(['tasks' => function ($query) use ($userId) {
                $query->where('user_id', $userId);
            }])
            ->get();

        // Get recent tasks
        $recentTasks = Task::where('user_id', $userId)
            ->with('category')
            ->orderBy('updated_at', 'desc')
            ->take(5)
            ->get();

        // Get upcoming tasks
        $upcomingTasks = Task::where('user_id', $userId)
            ->with('category')
            ->where('due_date', '>=', Carbon::now())
            ->orderBy('due_date', 'asc')
            ->take(5)
            ->get();

        // Prepare chart data (last 7 days)
        $chartData = $this->prepareChartData($userId);

        // Prepare category pie chart data
        $categoryLabels = $categoryStats->pluck('category_type')->map(function($type) {
            return ucfirst($type);
        });
        $categoryData = $categoryStats->pluck('tasks_count');

        return view('User_view.Productivity_insight', compact(
            'totalTasks',
            'completedTasks',
            'inProgressTasks',
            'pendingTasks',
            'categoryStats',
            'recentTasks',
            'upcomingTasks',
            'chartData',
            'categoryLabels',
            'categoryData'
        ));
    }

    private function prepareChartData($userId)
    {
        $labels = [];
        $data = [];

        // Get data for the last 7 days
        for ($i = 6; $i >= 0; $i--) {
            $date = Carbon::now()->subDays($i);
            $labels[] = $date->format('M d');

            $completedCount = Task::where('user_id', $userId)
                ->where('status', 'complete')
                ->whereDate('updated_at', $date)
                ->count();

            $data[] = $completedCount;
        }

        return [
            'labels' => $labels,
            'data' => $data
        ];
    }
}
