@extends('admin.layout')

@section('title', 'Créer un nouveau Quiz')

@section('content')
<div style="max-width:600px; margin: 3rem auto; background: white; padding: 2rem; border-radius: 8px; box-shadow: 0 4px 10px rgb(0 0 0 / 0.1); font-family: 'Segoe UI', Tahoma, sans-serif; color: #1e293b;">

  <h1 style="font-weight: 700; font-size: 1.8rem; margin-bottom: 1.5rem; color: #334155;">Créer un nouveau Quiz</h1>

  @if ($errors->any())
    <div style="background:#fee2e2; color:#b91c1c; padding:0.75rem 1rem; border-radius:6px; margin-bottom: 1rem;">
      <ul style="margin:0; padding-left: 1.2rem;">
        @foreach ($errors->all() as $error)
          <li>{{ $error }}</li>
        @endforeach
      </ul>
    </div>
  @endif

  <form action="{{ route('quizzes.store') }}" method="POST" style="display:flex; flex-direction: column; gap: 1.25rem;">
    @csrf

    <input type="text" name="title" placeholder="Titre" required
      style="padding: 0.6rem 1rem; font-size: 1rem; border: 1.5px solid #cbd5e1; border-radius: 6px; transition: border-color 0.3s;">

    <input type="number" name="duration_minutes" placeholder="Durée (minutes)" min="1" required
      style="padding: 0.6rem 1rem; font-size: 1rem; border: 1.5px solid #cbd5e1; border-radius: 6px; transition: border-color 0.3s;">

    <select name="lesson_id" required
      style="padding: 0.6rem 1rem; font-size: 1rem; border: 1.5px solid #cbd5e1; border-radius: 6px; transition: border-color 0.3s;">
      <option value="" disabled selected>Choisir une leçon</option>
      @foreach ($lessons as $lesson)
        <option value="{{ $lesson->id }}">{{ $lesson->title }}</option>
      @endforeach
    </select>

    <button type="submit" style="background-color: #2563eb; color: white; padding: 0.75rem 1rem; font-weight: 600; font-size: 1rem; border: none; border-radius: 6px; cursor: pointer; transition: background-color 0.3s;">
      Créer
    </button>
  </form>
</div>
@endsection
