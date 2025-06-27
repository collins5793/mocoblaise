<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class Course extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'image',
        'admin_id',
    ];

    // Relation avec l'admin (ou formateur)
    public function admin()
    {
        return $this->belongsTo(User::class, 'admin_id');
    }

    public function lessons() {
        return $this->hasMany(Lesson::class);
    }

    public function users()
{
    return $this->belongsToMany(User::class, 'user_courses')->withPivot('started_at', 'completed_at', 'progress', 'status')->withTimestamps();
}


}
