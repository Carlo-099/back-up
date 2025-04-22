<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Reference extends Model
{
    protected $primaryKey = 'reference_id';

    protected $fillable = [
        'user_id',
        'settings_id'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function settings()
    {
        return $this->belongsTo(Setting::class, 'settings_id', 'id');
    }
}
