<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Lesson extends Model
{
    use HasFactory;

    protected $fillable = [
        'course_id',
        'title',
        'content_type',
        'content_url',
        'order',
    ];

    // Relation avec le cours
    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    // Si besoin d’associer à un quiz par la suite
    public function quizzes()
    {
        return $this->hasMany(Quiz::class);
    }
}
