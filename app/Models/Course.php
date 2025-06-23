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
}
