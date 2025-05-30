<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'age',
        'gender',
        'educational_level',
        'last_login_at',
        'is_admin',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
        'last_login_at' => 'datetime',
        'is_admin' => 'boolean',
    ];

    /**
     * Get the reference associated with the user.
     */
    public function reference()
    {
        return $this->hasOne(Reference::class, 'user_id', 'id');
    }

    public function updateLastLogin()
    {
        \Illuminate\Support\Facades\Log::info('Updating last login', [
            'user_id' => $this->id,
            'old_last_login' => $this->last_login_at
        ]);

        $this->last_login_at = now();
        $this->save();

        \Illuminate\Support\Facades\Log::info('Last login updated in model', [
            'user_id' => $this->id,
            'new_last_login' => $this->last_login_at
        ]);
    }

    public function notifications()
    {
        return $this->hasMany(Notification::class);
    }

    public function hasUnreadNotifications()
    {
        return $this->notifications()->where('status', 'unread')->exists();
    }
}
