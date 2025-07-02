<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class UserCourse extends Model
{
    use HasFactory;

    protected $table = 'user_courses';

    protected $fillable = [
        'user_id',
        'course_id',
        'started_at',
        'completed_at',
        'progress',
        'status',
    ];

    protected $dates = [
        'started_at',
        'completed_at',
        'created_at',
        'updated_at',
    ];

    // Relation vers l'utilisateur
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relation vers le cours
    public function course()
    {
        return $this->belongsTo(Course::class);
    }
}
