<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'start_date',
        'deadline_date',
        'priority',
        'status',
    ];

    // Relasi: Sebuah Project dapat dimiliki oleh banyak User (PIC)
    public function pics()
    {
        return $this->belongsToMany(User::class, 'project_user', 'project_id', 'user_id');
    }

    // Relasi: Sebuah Project memiliki banyak Comment
    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    // Relasi: Sebuah Project memiliki banyak Attachment
    public function attachments()
    {
        return $this->hasMany(Attachment::class);
    }
}