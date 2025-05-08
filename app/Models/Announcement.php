<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Announcement extends Model
{
    use HasFactory;

    protected $primaryKey = 'announcement_id';

    protected $fillable = [
        'user_id',
        'message_anounce',
        'created_at',
        'updated_at'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function markAsRead($userId)
    {
        // Create or update the read status in the announcement_reads table
        $this->reads()->updateOrCreate(
            ['user_id' => $userId],
            ['read_at' => now()]
        );
    }

    public function isReadBy($userId)
    {
        return $this->reads()->where('user_id', $userId)->exists();
    }

    public function reads()
    {
        return $this->hasMany(AnnouncementRead::class, 'announcement_id', 'announcement_id');
    }
}
