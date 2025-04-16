<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TaskSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('tasks')->insert([
            'user_id' => 2,
            'title' => 'test part',
            'description' => 'this is a test part',
            'due_date' => '2024-03-02',
            'status' => 'pending',
            'category_id' => 1
        ]);
    }
}
