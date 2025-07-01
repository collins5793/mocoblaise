@extends('admin.layout')

@section('title', 'Gestion Utilisateurs')

@section('content')
<h2>Gestion des utilisateurs</h2>

<form method="GET" action="{{ route('admin.users.index') }}" style="margin-bottom: 1rem; display: flex; gap: 0.5rem; flex-wrap: wrap; align-items: center;">
    <input type="text" name="search" placeholder="Rechercher par nom ou email" value="{{ request('search') }}" style="padding:0.5rem; width: 300px; border-radius:5px; border:1px solid #ccc;" />

    <select name="role" style="padding:0.5rem; border-radius:5px; border:1px solid #ccc;">
        <option value="">Tous les rôles</option>
        <option value="admin" {{ request('role') == 'admin' ? 'selected' : '' }}>Administrateur</option>
        <option value="etudiant" {{ request('role') == 'etudiant' ? 'selected' : '' }}>Étudiant</option>
        <!-- Ajoute ici d'autres rôles si besoin -->
    </select>

    <button type="submit" style="padding:0.5rem 1rem; background:#007bff; color:white; border:none; border-radius:5px; cursor:pointer;">Rechercher</button>

    <a href="{{ route('admin.users.export') }}" style="margin-left:auto; background:#28a745; color:white; padding:0.5rem 1rem; border-radius:5px; text-decoration:none;">Exporter CSV</a>
</form>

<table style="width:100%; border-collapse: collapse; background:#fff; box-shadow: 0 0 10px rgb(0 0 0 / 0.1); border-radius:10px; overflow:hidden;">
    <thead>
        <tr style="background:#007bff; color:#fff;">
            <th style="padding:1rem;">Nom</th>
            <th>Email</th>
            <th>Rôle</th>
            <th>Date inscription</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        @forelse ($users as $user)
            <tr style="border-bottom: 1px solid #ddd;">
                <td style="padding:0.75rem;">{{ $user->name }}</td>
                <td>{{ $user->email }}</td>
                <td>{{ ucfirst($user->role) }}</td>
                <td>{{ $user->created_at->format('d/m/Y') }}</td>
                <td>
                    <form method="POST" action="{{ route('admin.users.destroy', $user->id) }}" onsubmit="return confirm('Voulez-vous vraiment supprimer cet utilisateur ?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" style="background:#dc3545; color:white; border:none; padding:0.4rem 0.8rem; border-radius:5px; cursor:pointer;">Supprimer</button>
                    </form>
                </td>
            </tr>
        @empty
            <tr><td colspan="5" style="padding:1rem; text-align:center;">Aucun utilisateur trouvé.</td></tr>
        @endforelse
    </tbody>
</table>

<div style="margin-top: 1rem;">
    {{ $users->withQueryString()->links() }}
</div>
@endsection
