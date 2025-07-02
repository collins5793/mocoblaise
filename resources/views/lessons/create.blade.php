<link rel="stylesheet" href="https://unpkg.com/trix@2.0.0/dist/trix.css">
<script src="https://unpkg.com/trix@2.0.0/dist/trix.umd.min.js"></script>
@extends('admin.layout')

@section('title', 'Ajouter des Leçons')

@section('content')
<div class="container" style="max-width: 800px; margin: 3rem auto; padding: 2rem; background-color: #fff; border-radius: 10px; box-shadow: 0 4px 10px rgba(0,0,0,0.05); color: #1f2937; font-family: 'Segoe UI', Tahoma, sans-serif;">
  <h1 style="font-size: 1.8rem; margin-bottom: 1.5rem; font-weight: bold; color: #111827;">Ajouter des Leçons</h1>

  <form method="POST" action="{{ route('lessons.store') }}">
    @csrf

    @if ($errors->any())
      <div style="color: red; margin-bottom: 10px;">
        <ul>
          @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
          @endforeach
        </ul>
      </div>
    @endif

    <input type="hidden" name="course_id" value="{{ $courseId }}">

    <div id="lesson-fields">
      <div class="lesson-group" data-index="0" style="padding: 1.5rem; border: 1px solid #e5e7eb; border-radius: 8px; margin-bottom: 1.5rem; background-color: #f1f5f9;">
        <h2 style="font-size: 1.2rem; margin-bottom: 1rem; font-weight: 600;">Leçon 1</h2>

        <label style="display:block; margin-bottom: 0.5rem; font-weight: 500; color: #374151;">Titre</label>
        <input type="text" name="lessons[0][title]" required
               style="width: 100%; padding: 0.65rem; margin-bottom: 1rem; border: 1px solid #d1d5db; border-radius: 6px; font-size: 1rem; background-color: #f9fafb;">

        <label style="display:block; margin-bottom: 0.5rem; font-weight: 500; color: #374151;">Type de contenu</label>
        <select name="lessons[0][content_type]" class="content-type" onchange="handleTypeChange(this)"
                style="width: 100%; padding: 0.65rem; margin-bottom: 1rem; border: 1px solid #d1d5db; border-radius: 6px; font-size: 1rem; background-color: #f9fafb;">
          <option value="texte">Texte</option>
          <option value="pdf">PDF</option>
          <option value="document">Document</option>
        </select>

        <div class="content-texte">
          <input type="hidden" name="lessons[0][content_url]" id="content0">
          <trix-editor input="content0" style="background-color: white; min-height: 150px; margin-bottom: 1rem; border: 1px solid #d1d5db; border-radius: 6px; padding: 10px;"></trix-editor>
        </div>

        <div class="content-url" style="display: none;">
          <label style="display:block; margin-bottom: 0.5rem; font-weight: 500; color: #374151;">URL du contenu</label>
          <input type="text" name="lessons[0][content_url_alt]" 
                 style="width: 100%; padding: 0.65rem; margin-bottom: 1rem; border: 1px solid #d1d5db; border-radius: 6px; font-size: 1rem; background-color: #f9fafb;">
        </div>

        <label style="display:block; margin-bottom: 0.5rem; font-weight: 500; color: #374151;">Ordre (facultatif)</label>
        <input type="number" name="lessons[0][order]"
               style="width: 100%; padding: 0.65rem; margin-bottom: 1rem; border: 1px solid #d1d5db; border-radius: 6px; font-size: 1rem; background-color: #f9fafb;">
      </div>
    </div>

    <button type="button" class="btn-add" onclick="addLesson()" 
            style="background-color: #16a34a; color: white; margin-right: 0.8rem; padding: 0.6rem 1.5rem; font-size: 1rem; font-weight: 600; border: none; border-radius: 6px; cursor: pointer; transition: background-color 0.3s ease;">
      Ajouter une autre leçon
    </button>
    <button type="submit" class="btn-submit" 
            style="background-color: #2563eb; color: white; padding: 0.6rem 1.5rem; font-size: 1rem; font-weight: 600; border: none; border-radius: 6px; cursor: pointer; transition: background-color 0.3s ease;">
      Valider les leçons
    </button>
  </form>
</div>
@endsection

@push('styles')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/trix/2.0.0/trix.css">
@endpush

@push('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/trix/2.0.0/trix.umd.min.js"></script>

<script>
  let lessonCount = 1;

  function addLesson() {
    const container = document.getElementById('lesson-fields');
    const newIndex = lessonCount;

    const group = document.createElement('div');
    group.classList.add('lesson-group');
    group.dataset.index = newIndex;
    group.style.padding = "1.5rem";
    group.style.border = "1px solid #e5e7eb";
    group.style.borderRadius = "8px";
    group.style.marginBottom = "1.5rem";
    group.style.backgroundColor = "#f1f5f9";

    group.innerHTML = `
      <h2 style="font-size: 1.2rem; margin-bottom: 1rem; font-weight: 600;">Leçon ${newIndex + 1}</h2>

      <label style="display:block; margin-bottom: 0.5rem; font-weight: 500; color: #374151;">Titre</label>
      <input type="text" name="lessons[${newIndex}][title]" required
        style="width: 100%; padding: 0.65rem; margin-bottom: 1rem; border: 1px solid #d1d5db; border-radius: 6px; font-size: 1rem; background-color: #f9fafb;">

      <label style="display:block; margin-bottom: 0.5rem; font-weight: 500; color: #374151;">Type de contenu</label>
      <select name="lessons[${newIndex}][content_type]" class="content-type" onchange="handleTypeChange(this)"
        style="width: 100%; padding: 0.65rem; margin-bottom: 1rem; border: 1px solid #d1d5db; border-radius: 6px; font-size: 1rem; background-color: #f9fafb;">
        <option value="texte">Texte</option>
        <option value="pdf">PDF</option>
        <option value="document">Document</option>
      </select>

      <div class="content-texte">
        <input type="hidden" name="lessons[${newIndex}][content_url]" id="content${newIndex}">
        <trix-editor input="content${newIndex}" style="background-color: white; min-height: 150px; margin-bottom: 1rem; border: 1px solid #d1d5db; border-radius: 6px; padding: 10px;"></trix-editor>
      </div>

      <div class="content-url" style="display: none;">
        <label style="display:block; margin-bottom: 0.5rem; font-weight: 500; color: #374151;">URL du contenu</label>
        <input type="text" name="lessons[${newIndex}][content_url_alt]" 
          style="width: 100%; padding: 0.65rem; margin-bottom: 1rem; border: 1px solid #d1d5db; border-radius: 6px; font-size: 1rem; background-color: #f9fafb;">
      </div>

      <label style="display:block; margin-bottom: 0.5rem; font-weight: 500; color: #374151;">Ordre (facultatif)</label>
      <input type="number" name="lessons[${newIndex}][order]" 
        style="width: 100%; padding: 0.65rem; margin-bottom: 1rem; border: 1px solid #d1d5db; border-radius: 6px; font-size: 1rem; background-color: #f9fafb;">
    `;

    container.appendChild(group);
    lessonCount++;
  }

  function handleTypeChange(select) {
    const group = select.closest('.lesson-group');
    const texteDiv = group.querySelector('.content-texte');
    const urlDiv = group.querySelector('.content-url');

    const hiddenInput = texteDiv.querySelector('input[type="hidden"]');
    const urlInput = urlDiv.querySelector('input[type="text"]');

    if (select.value === 'texte') {
      texteDiv.style.display = 'block';
      urlDiv.style.display = 'none';

      hiddenInput.disabled = false;
      urlInput.disabled = true;
    } else {
      texteDiv.style.display = 'none';
      urlDiv.style.display = 'block';

      hiddenInput.disabled = true;
      urlInput.disabled = false;
    }
  }
</script>
@endpush
