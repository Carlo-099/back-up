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
        'notification'
    ];

    protected $casts = [
        'notification' => 'boolean'
    ];

    public function references()
    {
        return $this->hasMany(Reference::class, 'settings_id', 'id');
    }
}
