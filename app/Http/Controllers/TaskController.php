<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\Category;
use App\Models\Status;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class TaskController extends Controller
{
    public function store(Request $request)
    {
        try {
            $request->validate([
                'title' => 'required|string|max:255',
                'description' => 'required|string',
                'status' => 'required|in:pending,in_progress,complete',
                'due_date' => 'required|date',
                'category_type' => 'required|in:home,school,outdoors'
            ]);

            // Get the category ID based on the category type
            $category = Category::where('category_type', $request->category_type)
                ->where('user_id', Auth::id())
                ->first();

            if (!$category) {
                // Create the category if it doesn't exist
                $category = Category::create([
                    'user_id' => Auth::id(),
                    'category_type' => $request->category_type
                ]);
            }

            // Create the task
            $task = Task::create([
                'user_id' => Auth::id(),
                'title' => $request->title,
                'description' => $request->description,
                'status' => $request->status,
                'due_date' => $request->due_date,
                'category_id' => $category->category_id
            ]);

            // Update status counts
            Status::updateCounts();

            // Format the task data for UI
            $taskData = [
                'id' => $task->task_id,
                'title' => $task->title,
                'description' => $task->description,
                'status' => $task->status,
                'due_date' => $task->due_date->format('Y-m-d'),
                'category_type' => $request->category_type
            ];

            return response()->json([
                'success' => true,
                'message' => 'Task created successfully',
                'task' => $taskData
            ]);
        } catch (\Exception $e) {
            Log::error('Task creation error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error creating task: ' . $e->getMessage()
            ], 500);
        }
    }
}
