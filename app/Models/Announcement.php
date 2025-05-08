<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Announcement extends Model
{
    use HasFactory;

    protected $primaryKey = 'announcement_id';

    protected $fillable = [
        'users_id',
        'message_anounce'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'users_id');
    }
}
