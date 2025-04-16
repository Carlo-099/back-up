<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $primaryKey = 'category_id';

    protected $fillable = [
        'user_id',
        'category_type'
    ];

    public function tasks()
    {
        return $this->hasMany(Task::class, 'category_id', 'category_id');
    }
}
