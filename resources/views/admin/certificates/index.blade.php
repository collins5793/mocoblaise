@extends('admin.layout')

@section('title', 'Gestion des certificats')

@section('content')
<h2>Liste des certificats générés</h2>

@if(session('success'))
    <div style="color: green; margin-bottom: 1rem;">{{ session('success') }}</div>
@endif
@if(session('error'))
    <div style="color: red; margin-bottom: 1rem;">{{ session('error') }}</div>
@endif
@if(session('message'))
    <div style="color: orange; margin-bottom: 1rem;">{{ session('message') }}</div>
@endif

<form method="GET" action="{{ route('admin.certificates.index') }}" style="margin-bottom: 1rem; display:flex; flex-wrap: wrap; gap: 0.5rem; align-items: center;">
    <input type="text" name="user" placeholder="Rechercher par utilisateur" value="{{ request('user') }}" style="padding: 0.4rem 0.6rem;">
    <input type="text" name="course" placeholder="Rechercher par cours" value="{{ request('course') }}" style="padding: 0.4rem 0.6rem;">
    <input type="date" name="date" value="{{ request('date') }}" style="padding: 0.4rem 0.6rem; max-width: 160px;">
    <button type="submit" style="padding: 0.4rem 1rem; background:#007bff; color:white; border:none; border-radius:5px; cursor:pointer;">Rechercher</button>

    <a href="{{ route('admin.certificates.exportCsv', request()->query()) }}" 
       style="margin-left:auto; background:#28a745; color:white; padding: 0.4rem 1rem; border-radius:5px; text-decoration:none;">📥 Export CSV</a>
</form>


<table style="width:100%; border-collapse: collapse; background:#fff; box-shadow: 0 0 10px rgb(0 0 0 / 0.1); border-radius:10px; overflow:hidden;">
    <thead>
        <tr style="background:#007bff; color:#fff;">
            <th style="padding: 1rem; text-align:left;">Utilisateur</th>
            <th>Cours</th>
            <th>PDF</th>
            <th>Date de génération</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        @forelse ($certificates as $certificate)
            <tr style="border-bottom: 1px solid #ddd;">
                <td style="padding: 0.75rem;">{{ $certificate->user->name ?? 'Utilisateur supprimé' }}</td>
                <td>{{ $certificate->course->title ?? 'Cours supprimé' }}</td>
                <td>
                    <a href="{{ asset('storage/' . $certificate->pdf_url) }}" target="_blank" style="color:#007bff;">Voir PDF</a>
                </td>
                <td>{{ \Carbon\Carbon::parse($certificate->generated_at)->format('d/m/Y H:i') }}</td>
                <td>
                    <form action="{{ route('admin.certificates.download', $certificate->course_id) }}" method="GET" style="display:inline;">
                        <button type="submit" style="background:#17a2b8; color:white; border:none; padding:0.3rem 0.6rem; border-radius:5px; cursor:pointer;">Télécharger</button>
                    </form>
                </td>
            </tr>
        @empty
            <tr><td colspan="5" style="padding:1rem; text-align:center;">Aucun certificat généré pour le moment.</td></tr>
        @endforelse
    </tbody>
</table>

<div style="margin-top:1rem;">
    {{ $certificates->links() }}
</div>

@endsection
