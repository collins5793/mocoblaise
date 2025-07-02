<link rel="stylesheet" href="https://unpkg.com/trix@2.0.0/dist/trix.css">
<script src="https://unpkg.com/trix@2.0.0/dist/trix.umd.min.js"></script>
@extends('admin.layout')

@section('title', 'Modifier la leçon')

@section('content')
<div class="container" style="max-width: 800px; margin: 2rem auto; background: #fff; padding: 2rem; border-radius: 10px; box-shadow: 0 4px 10px rgba(0,0,0,0.05);">

    <h1 style="margin-bottom: 1.5rem;">Modifier la leçon</h1>

    <form method="POST" action="{{ route('lessons.update', $lesson->id) }}">
        @csrf
        @method('PUT')

        @if ($errors->any())
          <div style="color: red; margin-bottom: 10px;">
            <ul>
              @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
              @endforeach
            </ul>
          </div>
        @endif

        <label for="title">Titre</label>
        <input type="text" id="title" name="title" value="{{ old('title', $lesson->title) }}" required
               style="width: 100%; padding: 0.65rem; margin-bottom: 1rem; border: 1px solid #d1d5db; border-radius: 6px; background-color: #f9fafb;">

        <label for="content_type">Type de contenu</label>
        <select id="content_type" name="content_type" class="content-type" onchange="handleTypeChange(this)"
                style="width: 100%; padding: 0.65rem; margin-bottom: 1rem; border: 1px solid #d1d5db; border-radius: 6px; background-color: #f9fafb;">
            <option value="texte" {{ old('content_type', $lesson->content_type) == 'texte' ? 'selected' : '' }}>Texte</option>
            <option value="pdf" {{ old('content_type', $lesson->content_type) == 'pdf' ? 'selected' : '' }}>PDF</option>
            <option value="document" {{ old('content_type', $lesson->content_type) == 'document' ? 'selected' : '' }}>Document</option>
        </select>

        <div class="content-texte" style="{{ old('content_type', $lesson->content_type) == 'texte' ? 'display:block;' : 'display:none;' }}">
            <input type="hidden" id="content_url" name="content_url" value="{{ old('content_url', $lesson->content_url) }}">
            <trix-editor input="content_url" style="background: white; min-height: 150px; margin-bottom: 1rem; border: 1px solid #d1d5db; border-radius: 6px; padding: 10px;"></trix-editor>
        </div>

        <div class="content-url" style="{{ old('content_type', $lesson->content_type) != 'texte' ? 'display:block;' : 'display:none;' }}">
            <label for="content_url_alt">URL du contenu</label>
            <input type="text" id="content_url_alt" name="content_url" value="{{ old('content_url', $lesson->content_url) }}"
                   style="width: 100%; padding: 0.65rem; margin-bottom: 1rem; border: 1px solid #d1d5db; border-radius: 6px; background-color: #f9fafb;">
        </div>

        <label for="order">Ordre (facultatif)</label>
        <input type="number" id="order" name="order" value="{{ old('order', $lesson->order) }}"
               style="width: 100%; padding: 0.65rem; margin-bottom: 1.5rem; border: 1px solid #d1d5db; border-radius: 6px; background-color: #f9fafb;">

        <button type="submit" style="padding: 0.6rem 1.5rem; font-size: 1rem; font-weight: 600; border: none; border-radius: 6px; cursor: pointer; background-color: #2563eb; color: white;">
            Enregistrer les modifications
        </button>
    </form>
</div>

<!-- Trix Editor CSS & JS -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/trix/2.0.0/trix.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/trix/2.0.0/trix.umd.min.js"></script>

<script>
function handleTypeChange(select) {
    const contentType = select.value;
    const texteDiv = document.querySelector('.content-texte');
    const urlDiv = document.querySelector('.content-url');

    if(contentType === 'texte') {
        texteDiv.style.display = 'block';
        urlDiv.style.display = 'none';
    } else {
        texteDiv.style.display = 'none';
        urlDiv.style.display = 'block';
    }
}
</script>
@endsection
