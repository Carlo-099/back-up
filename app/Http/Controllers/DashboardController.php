<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Task;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function getStats(): JsonResponse
    {
        // Get total regular users and new users this month
        $totalUsers = User::where('is_admin', false)->count();
        $newUsers = User::where('is_admin', false)
            ->whereMonth('created_at', Carbon::now()->month)
            ->count();

        // Get last month's user count for growth calculation
        $lastMonthUsers = User::where('is_admin', false)
            ->where('created_at', '<', Carbon::now()->startOfMonth())
            ->where('created_at', '>=', Carbon::now()->subMonth()->startOfMonth())
            ->count();

        // Get gender distribution
        $gender = User::where('is_admin', false)
            ->select('gender', DB::raw('count(*) as count'))
            ->groupBy('gender')
            ->pluck('count')
            ->toArray();

        // Get age distribution
        $ageGroups = User::where('is_admin', false)
            ->select(
                DB::raw('CASE
                    WHEN age < 25 THEN "18-24"
                    WHEN age < 35 THEN "25-34"
                    WHEN age < 45 THEN "35-44"
                    WHEN age < 55 THEN "45-54"
                    ELSE "55+"
                END as age_group'),
                DB::raw('count(*) as count')
            )
            ->groupBy('age_group')
            ->orderBy('age_group')
            ->pluck('count')
            ->toArray();

        // Get education level distribution
        $education = User::where('is_admin', false)
            ->select('educational_level', DB::raw('count(*) as count'))
            ->groupBy('educational_level')
            ->pluck('count')
            ->toArray();

        // Get task statistics
        $taskStats = Task::select('status', DB::raw('count(*) as count'))
            ->groupBy('status')
            ->pluck('count')
            ->toArray();

        // Get user activity for the last 7 days
        $activity = User::where('is_admin', false)
            ->where('last_login_at', '>=', Carbon::now()->subDays(7))
            ->select(
                DB::raw('DATE(last_login_at) as date'),
                DB::raw('count(*) as count')
            )
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        $activityLabels = $activity->pluck('date')->map(function ($date) {
            return Carbon::parse($date)->format('M d');
        })->toArray();
        $activityData = $activity->pluck('count')->toArray();

        // Get recently active users
        $activeUsers = User::where('is_admin', false)
            ->whereNotNull('last_login_at')
            ->orderBy('last_login_at', 'desc')
            ->take(5)
            ->get()
            ->map(function ($user) {
                // Get profile picture from settings through references
                $profilePicture = DB::table('references')
                    ->join('settings', 'references.settings_id', '=', 'settings.id')
                    ->where('references.user_id', $user->id)
                    ->value('settings.profile_picture');

                return [
                    'name' => $user->name,
                    'last_active' => Carbon::parse($user->last_login_at)->diffForHumans(),
                    'profile_picture' => $profilePicture ?? null
                ];
            });

        // Get recent task completions
        $recentTasks = Task::with('user')
            ->where('status', 'completed')
            ->orderBy('updated_at', 'desc')
            ->take(5)
            ->get()
            ->map(function ($task) {
                return [
                    'user_name' => $task->user->name,
                    'title' => $task->title
                ];
            });

        return response()->json([
            'totalUsers' => $totalUsers,
            'newUsers' => $newUsers,
            'lastMonthUsers' => $lastMonthUsers,
            'gender' => $gender,
            'age' => $ageGroups,
            'education' => $education,
            'taskStats' => $taskStats,
            'activity' => [
                'labels' => $activityLabels,
                'data' => $activityData
            ],
            'activeUsers' => $activeUsers,
            'recentTasks' => $recentTasks
        ]);
    }
}
