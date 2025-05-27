<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    protected $fillable = [
        'change_email',
        'change_password',
        'profile_picture',
        'theme',
        'notification',
        'notification_announcements',
        'notification_admin_responses',
        'notification_tasks'
    ];

    protected $casts = [
        'notification' => 'boolean',
        'notification_announcements' => 'boolean',
        'notification_admin_responses' => 'boolean',
        'notification_tasks' => 'boolean'
    ];

    public function references()
    {
        return $this->hasMany(Reference::class, 'settings_id', 'id');
    }
}
