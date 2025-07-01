<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class UserQuizAttempt extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'quiz_id',
        'score',
        'passed',
        'attempted_at',
    ];

    protected $dates = ['attempted_at'];

    // 🔁 Relations
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function quiz()
    {
        return $this->belongsTo(Quiz::class);
    }
    // App\Models\UserQuizAttempt.php
protected $casts = [
    'attempted_at' => 'datetime',
];

}
