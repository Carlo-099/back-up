<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index()
    {
        $tasks = Task::with('category')->get();
        return view('User_view.Category', compact('tasks'));
    }
}
