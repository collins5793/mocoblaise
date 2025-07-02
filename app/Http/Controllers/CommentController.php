<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Comment;
use App\Models\Course;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    public function store(Request $request, Course $course)
    {
                $user = Auth::user();

        $request->validate([
            'comment_text' => 'required|string|max:1000',
        ]);

        Comment::create([
            'user_id' => Auth::id(),
            'course_id' => $course->id,
            'comment_text' => $request->input('comment_text'),
        ]);

        return redirect()->back()->with('success', 'Commentaire ajouté avec succès !');
    }
}
