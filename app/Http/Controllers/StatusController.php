<?php

namespace App\Http\Controllers;

use App\Models\Status;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Task;
use Illuminate\Support\Facades\Auth;

class StatusController extends Controller
{
    public function index()
    {
        // Fetch tasks from the tasks table for the current user only
        $tasks = Task::with('category')
            ->where('user_id', Auth::id())
            ->get();

        // If no tasks found, initialize as empty collection to avoid errors
        if ($tasks->isEmpty()) {
            $tasks = collect([]);
        }

        return view('User_view.Status', compact('tasks'));
    }
}
