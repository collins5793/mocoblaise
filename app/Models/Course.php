<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    use HasFactory;

    // Table associée (optionnel si nom conforme "courses")
    protected $table = 'courses';

    // Champs modifiables en masse
    protected $fillable = [
        'title',
        'description',
        'image',
        'admin_id',
        'category',  // ajoute ce champ si tu l'as dans ta table
    ];

    // Relations

    /**
     * Un cours appartient à un administrateur (créateur)
     */
    public function admin()
    {
        return $this->belongsTo(User::class, 'admin_id');
    }

    /**
     * Un cours a plusieurs leçons
     */
    public function lessons()
    {
        return $this->hasMany(Lesson::class, 'course_id');
    }

    /**
     * Un cours peut avoir plusieurs QCM
     */
    public function quizzes()
    {
        return $this->hasMany(Quiz::class, 'course_id');
    }
}
