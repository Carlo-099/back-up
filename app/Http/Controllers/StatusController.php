<?php

namespace App\Http\Controllers;

use App\Models\Status;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Task;

class StatusController extends Controller
{
    public function index()
    {
        // Fetch tasks from the tasks table
        $tasks = Task::with('category')->get();

        // If no tasks found, initialize as empty collection to avoid errors
        if ($tasks->isEmpty()) {
            $tasks = collect([]);
        }

        return view('User_view.Status', compact('tasks'));
    }
}
