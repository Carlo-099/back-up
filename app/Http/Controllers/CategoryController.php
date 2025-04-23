<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CategoryController extends Controller
{
    public function index()
    {
        $tasks = Task::with('category')
            ->where('user_id', Auth::id())
            ->get();
        return view('User_view.Category', compact('tasks'));
    }
}
