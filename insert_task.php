<?php

require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';

$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\DB;

// Get the category
$category = DB::table('categories')->where('category_type', 'home')->first();

// Insert the task
DB::table('tasks')->insert([
    'user_id' => 2,
    'title' => 'test home task',
    'description' => 'this is a test task for home act',
    'due_date' => '2024-03-02',
    'status' => 'pending',
    'category_id' => $category->category_id
]);

// Show the result
$tasks = DB::table('tasks')->get();
print_r($tasks);
