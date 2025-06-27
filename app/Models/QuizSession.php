<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class QuizSession extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'quiz_id',
        'start_time',
        'expiration_time',
        'status',
    ];

    protected $casts = [
        'start_time' => 'datetime',
        'expiration_time' => 'datetime',
    ];

    protected $dates = ['start_time', 'expiration_time'];

    // 🔁 Relations
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function quiz()
    {
        return $this->belongsTo(Quiz::class);
    }
}
