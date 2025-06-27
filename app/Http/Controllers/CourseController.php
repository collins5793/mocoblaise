<?php

namespace App\Http\Controllers;

use App\Models\Course;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

class CourseController extends Controller
{
    public function index()
    {
        $courses = Course::where('admin_id', Auth::id())->get();
        return view('courses.index', compact('courses'));
    }

    public function create()
    {
        return view('courses.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title'       => 'required|string|max:255',
            'description' => 'required|string',
            'image'       => 'nullable|image|max:2048',
        ]);

        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('courses', 'public');
        }

        $course = Course::create([
            'title'       => $request->title,
            'description' => $request->description,
            'image'       => $imagePath,
            'admin_id'    => Auth::id(),
        ]);

        return redirect()->route('lessons.create', ['course' => $course->id])
        ->with('success', 'Cours créé avec succès. Ajoutez maintenant les leçons.');
    }

    public function edit(Course $course)
    {
        return view('courses.edit', compact('course'));
    }

    public function update(Request $request, Course $course)
    {
        $request->validate([
            'title'       => 'required|string|max:255',
            'description' => 'required|string',
            'image'       => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('image')) {
            if ($course->image) {
                Storage::disk('public')->delete($course->image);
            }
            $course->image = $request->file('image')->store('courses', 'public');
        }

        $course->update([
            'title'       => $request->title,
            'description' => $request->description,
            'image'       => $course->image,
        ]);

        return redirect()->route('courses.index')->with('success', 'Cours mis à jour');
    }

    public function destroy(Course $course)
    {
        if ($course->image) {
            Storage::disk('public')->delete($course->image);
        }
        $course->delete();
        return redirect()->route('courses.index')->with('success', 'Cours supprimé');
    }

    public function show($id)
    {
        $course = Course::with(['lessons.quizzes'])->findOrFail($id);
        return view('courses.show', compact('course'));
    }

    public function byCategory($category)
    {
        $courses = Course::where('category', $category)->get();
        return view('courses.by-category', compact('courses', 'category'));
    }

    public function all(Request $request)
    {
        $search = $request->input('search');
        $courses = Course::query();

        if ($search) {
            $courses->where('title', 'like', "%$search%");
        }

        return view('courses.all', [
            'courses' => $courses->paginate(9),
            'search' => $search
        ]);
    }

}
