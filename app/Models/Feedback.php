<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Feedback extends Model
{
    use HasFactory;

    protected $table = 'feedback';

    protected $fillable = [
        'user_id',
        'title',
        'message',
        'admin_response',
        'is_read',
        'date_sent'
    ];

    protected $casts = [
        'date_sent' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'is_read' => 'boolean'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
