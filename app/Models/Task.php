<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    protected $primaryKey = 'task_id';

    protected $fillable = [
        'user_id',
        'title',
        'description',
        'due_date',
        'status',
        'category_id'
    ];

    protected $casts = [
        'due_date' => 'date'
    ];
}
