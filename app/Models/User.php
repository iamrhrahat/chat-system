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
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
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
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function conversationsAsUserOne()
{
    return $this->hasMany(Conversation::class, 'user_one_id');
}

public function conversationsAsUserTwo()
{
    return $this->hasMany(Conversation::class, 'user_two_id');
}

public function sentMessages()
{
    return $this->hasMany(Message::class, 'sender_id');
}

public function blocks()
{
    return $this->hasMany(Block::class, 'blocker_id');
}

public function blockedBy()
{
    return $this->hasMany(Block::class, 'blocked_id');
}
}
