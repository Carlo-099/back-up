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
            'weatherData'
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
