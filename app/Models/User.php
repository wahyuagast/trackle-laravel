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

    // Relasi: Seorang User bisa menjadi PIC untuk banyak Project
    public function projects()
    {
        return $this->hasMany(Project::class, 'pic_user_id');
    }

    // Relasi: Seorang User bisa membuat banyak Comment
    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    // Relasi: Seorang User bisa memiliki banyak Notification
    public function notifications()
    {
        return $this->hasMany(Notification::class);
    }
}
