<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class UserProgress extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'lesson_id',
        'is_completed',
        'completed_at',
    ];

    public $timestamps = true; // Active created_at et updated_at
}
