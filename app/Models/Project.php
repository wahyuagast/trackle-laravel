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
        'pic_user_id',
        'priority',
        'status',
    ];

    // Relasi: Sebuah Project dimiliki oleh satu User (PIC)
    public function pic()
    {
        return $this->belongsTo(User::class, 'pic_user_id');
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