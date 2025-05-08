<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class UserManageController extends Controller
{
    public function index()
    {
        // Get total users (excluding admins)
        $totalUsers = User::where('is_admin', false)->count();

        // Get new users this month
        $newUsersThisMonth = User::where('is_admin', false)
            ->whereMonth('created_at', now()->month)
            ->count();

        // Get active users (users who logged in within the last 30 days)
        $activeUsers = User::where('is_admin', false)
            ->where('last_login_at', '>=', now()->subDays(30))
            ->count();

        // Get average tasks per user
        $averageTasksPerUser = Task::whereHas('user', function($query) {
            $query->where('is_admin', false);
        })->count() / max($totalUsers, 1);

        // Get gender distribution
        $genderDistribution = User::where('is_admin', false)
            ->select('gender', DB::raw('count(*) as count'))
            ->groupBy('gender')
            ->pluck('count', 'gender')
            ->toArray();

        // Get age distribution
        $ageDistribution = User::where('is_admin', false)
            ->select(DB::raw('CASE
                WHEN age < 18 THEN "Under 18"
                WHEN age BETWEEN 18 AND 24 THEN "18-24"
                WHEN age BETWEEN 25 AND 34 THEN "25-34"
                WHEN age BETWEEN 35 AND 44 THEN "35-44"
                WHEN age BETWEEN 45 AND 54 THEN "45-54"
                ELSE "55+" END as age_group'),
                DB::raw('count(*) as count'))
            ->groupBy('age_group')
            ->pluck('count', 'age_group')
            ->toArray();

        // Get educational level distribution
        $educationDistribution = User::where('is_admin', false)
            ->select('educational_level', DB::raw('count(*) as count'))
            ->groupBy('educational_level')
            ->pluck('count', 'educational_level')
            ->toArray();

        // Get task statistics
        $taskStats = Task::whereHas('user', function($query) {
            $query->where('is_admin', false);
        })
        ->select('status', DB::raw('count(*) as count'))
        ->groupBy('status')
        ->get()
        ->pluck('count', 'status')
        ->toArray();

        $taskStatsData = [
            'complete' => $taskStats['complete'] ?? 0,
            'in_progress' => $taskStats['in_progress'] ?? 0,
            'pending' => $taskStats['pending'] ?? 0
        ];

        // Get all users for display
        $users = User::where('is_admin', false)
            ->with(['reference.settings'])
            ->get();

        // Get recent completed tasks
        $recentTasks = Task::with(['user', 'category'])
            ->where('status', 'complete')
            ->whereHas('user', function($query) {
                $query->where('is_admin', false);
            })
            ->orderBy('updated_at', 'desc')
            ->take(5)
            ->get()
            ->map(function($task) {
                return [
                    'user_name' => $task->user->name,
                    'title' => $task->title,
                    'completed_at' => $task->updated_at->diffForHumans(),
                    'category' => $task->category->category_type
                ];
            });

        // Get weather data
        $weatherData = $this->getWeatherData();

        return view('Admin_view.UserManage', compact(
            'totalUsers',
            'newUsersThisMonth',
            'activeUsers',
            'averageTasksPerUser',
            'genderDistribution',
            'ageDistribution',
            'educationDistribution',
            'users',
            'recentTasks',
            'weatherData',
            'taskStatsData'
        ));
    }

    public function show($id)
    {
        $user = User::with(['reference.settings'])
            ->where('is_admin', false)
            ->findOrFail($id);

        return response()->json($user);
    }

    public function update(Request $request, $id)
    {
        $user = User::where('is_admin', false)->findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $id,
            'age' => 'required|integer|min:13',
            'gender' => 'required|in:male,female',
            'educational_level' => 'required|in:elementary,high school,senior high,college',
        ]);

        $user->update($validated);

        return response()->json(['message' => 'User updated successfully', 'user' => $user]);
    }

    public function destroy($id)
    {
        $user = User::where('is_admin', false)->findOrFail($id);
        $user->delete();

        return response()->json(['message' => 'User deleted successfully']);
    }

    public function getDashboardStats()
    {
        // Get total users and new users
        $totalUsers = User::where('is_admin', false)->count();
        $newUsers = User::where('is_admin', false)
            ->whereMonth('created_at', now()->month)
            ->count();
        $lastMonthUsers = User::where('is_admin', false)
            ->whereMonth('created_at', now()->subMonth()->month)
            ->count();

        // Get gender distribution
        $genderData = User::where('is_admin', false)
            ->select('gender', DB::raw('count(*) as count'))
            ->groupBy('gender')
            ->get();
        $gender = [
            $genderData->where('gender', 'male')->first()->count ?? 0,
            $genderData->where('gender', 'female')->first()->count ?? 0
        ];

        // Get age distribution
        $ageData = User::where('is_admin', false)
            ->select(DB::raw('
                CASE
                    WHEN age BETWEEN 18 AND 24 THEN "18-24"
                    WHEN age BETWEEN 25 AND 34 THEN "25-34"
                    WHEN age BETWEEN 35 AND 44 THEN "35-44"
                    WHEN age BETWEEN 45 AND 54 THEN "45-54"
                    ELSE "55+"
                END as age_group'
            ), DB::raw('count(*) as count'))
            ->groupBy('age_group')
            ->orderBy('age_group')
            ->pluck('count')
            ->toArray();

        // Get education distribution
        $educationData = User::where('is_admin', false)
            ->select('educational_level', DB::raw('count(*) as count'))
            ->groupBy('educational_level')
            ->orderBy(DB::raw('FIELD(educational_level, "elementary", "high school", "senior high", "college")'))
            ->pluck('count')
            ->toArray();

        // Get task statistics
        $taskStats = Task::whereHas('user', function($query) {
            $query->where('is_admin', false);
        })
        ->select('status', DB::raw('count(*) as count'))
        ->groupBy('status')
        ->get()
        ->pluck('count', 'status')
        ->toArray();

        $taskStatsData = [
            'complete' => $taskStats['complete'] ?? 0,
            'in_progress' => $taskStats['in_progress'] ?? 0,
            'pending' => $taskStats['pending'] ?? 0
        ];

        // Get user activity for the last 7 days
        $activityData = User::where('is_admin', false)
            ->where('last_login_at', '>=', now()->subDays(7))
            ->select(DB::raw('DATE(last_login_at) as date'), DB::raw('count(distinct id) as count'))
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        $activity = [
            'labels' => $activityData->pluck('date')->map(function($date) {
                return Carbon::parse($date)->format('M d');
            })->toArray(),
            'data' => $activityData->pluck('count')->toArray()
        ];

        // Get active users
        $activeUsers = User::where('is_admin', false)
            ->where('last_login_at', '>=', now()->subDays(30))
            ->orderBy('last_login_at', 'desc')
            ->take(10)
            ->get()
            ->map(function($user) {
                return [
                    'name' => $user->name,
                    'profile_picture' => $user->reference?->settings?->profile_picture,
                    'last_active' => $user->last_login_at ? $user->last_login_at->diffForHumans() : 'Never'
                ];
            });

        // Get recent completed tasks
        $recentTasks = Task::with(['user', 'category'])
            ->where('status', 'complete')
            ->whereHas('user', function($query) {
                $query->where('is_admin', false);
            })
            ->orderBy('updated_at', 'desc')
            ->take(5)
            ->get()
            ->map(function($task) {
                return [
                    'user_name' => $task->user->name,
                    'title' => $task->title,
                    'completed_at' => $task->updated_at->diffForHumans()
                ];
            });

        return response()->json([
            'totalUsers' => $totalUsers,
            'newUsers' => $newUsers,
            'lastMonthUsers' => $lastMonthUsers,
            'gender' => $gender,
            'age' => $ageData,
            'education' => $educationData,
            'taskStats' => $taskStatsData,
            'activity' => $activity,
            'activeUsers' => $activeUsers,
            'recentTasks' => $recentTasks
        ]);
    }

    private function getWeatherData()
    {
        // You'll need to replace this with your actual weather API integration
        // For now, returning mock data
        return [
            'temperature' => 31,
            'condition' => 'Sunny',
            'date' => now()->format('l, F j, Y')
        ];
    }
}
