<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\Category;
use App\Models\Status;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use App\Models\Notification;

class TaskController extends Controller
{


    public function markAsRead($taskId)
    {
        try {
            $task = Task::findOrFail($taskId);

            // Check if the user owns this task
            if ($task->user_id !== Auth::id()) {
                return response()->json(['success' => false, 'message' => 'Unauthorized'], 403);
            }

            // Update the notification status
            $notification = Notification::updateOrCreate(
                ['user_id' => Auth::id(), 'task_id' => $taskId],
                ['status' => 'read']
            );

            return response()->json(['success' => true, 'message' => 'Notification marked as read']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Error marking notification as read'], 500);
        }
    }
    public function index()
    {
        try {
            $tasks = Task::with('category')
                ->where('user_id', Auth::id())
                ->get()
                ->map(function ($task) {
                    return [
                        'task_id' => $task->task_id,
                        'title' => $task->title,
                        'description' => $task->description,
                        'status' => $task->status,
                        'due_date' => $task->due_date->format('Y-m-d'),
                        'category_type' => $task->category->category_type
                    ];
                });

            return response()->json([
                'success' => true,
                'tasks' => $tasks
            ]);
        } catch (\Exception $e) {
            Log::error('Error fetching tasks: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error fetching tasks: ' . $e->getMessage()
            ], 500);
        }
    }

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

    public function update(Request $request, $id)
    {


        try {
            $request->validate([
                'title' => 'required|string|max:255',
                'description' => 'required|string',
                'status' => 'required|in:pending,in_progress,complete',
                'due_date' => 'required|date'
            ]);

            $task = Task::findOrFail($id);

            // Check if the user owns this task
            if ($task->user_id !== Auth::id()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Unauthorized'
                ], 403);
            }

            // Update the task
            $task->update([
                'title' => $request->title,
                'description' => $request->description,
                'status' => $request->status,
                'due_date' => $request->due_date
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
                'category_type' => $task->category->category_type
            ];

            return response()->json([
                'success' => true,
                'message' => 'Task updated successfully',
                'task' => $taskData
            ]);
        } catch (\Exception $e) {
            Log::error('Task update error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error updating task: ' . $e->getMessage()
            ], 500);
        }
    }

    public function destroy($id)
    {
        try {
            $task = Task::findOrFail($id);

            // Check if the user owns this task
            if ($task->user_id !== Auth::id()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Unauthorized'
                ], 403);
            }

            // Delete the task
            $task->delete();

            // Update status counts
            Status::updateCounts();

            return response()->json([
                'success' => true,
                'message' => 'Task deleted successfully'
            ]);
        } catch (\Exception $e) {
            Log::error('Task deletion error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error deleting task: ' . $e->getMessage()
            ], 500);
        }
    }

    public function complete($id)
    {
        try {
            $task = Task::findOrFail($id);

            // Check if the user owns this task
            if ($task->user_id !== Auth::id()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Unauthorized'
                ], 403);
            }

            // Update the task status to complete
            $task->status = 'complete';
            $task->save();

            // Update status counts
            Status::updateCounts();

            return response()->json([
                'success' => true,
                'message' => 'Task marked as complete'
            ]);
        } catch (\Exception $e) {
            Log::error('Task completion error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error completing task: ' . $e->getMessage()
            ], 500);
        }
    }
}
