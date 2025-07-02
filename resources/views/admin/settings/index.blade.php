@extends('admin.layout')

@section('title', 'Paramètres')

@section('content')
<h2>Paramètres de la plateforme</h2>

<form action="#" method="POST" onsubmit="alert('Fonction non implémentée'); return false;">
    @csrf

    <div style="margin-bottom: 1rem;">
        <label for="site_name">Nom du site</label><br />
        <input type="text" id="site_name" name="site_name" value="Mon super site" style="width: 100%; padding: 0.5rem;" disabled />
    </div>

    <div style="margin-bottom: 1rem;">
        <label for="contact_email">Email de contact</label><br />
        <input type="email" id="contact_email" name="contact_email" value="contact@example.com" style="width: 100%; padding: 0.5rem;" disabled />
    </div>

    <div style="margin-bottom: 1rem;">
        <label for="address">Adresse</label><br />
        <input type="text" id="address" name="address" value="12 rue de la Paix, Paris" style="width: 100%; padding: 0.5rem;" disabled />
    </div>

    <div style="margin-bottom: 1rem;">
        <label for="enable_feature">Activer une fonctionnalité X</label><br />
        <select id="enable_feature" name="enable_feature" disabled style="width: 100%; padding: 0.5rem;">
            <option value="1" selected>Oui</option>
            <option value="0">Non</option>
        </select>
    </div>

    <button type="submit" disabled style="background: #2563eb; color: white; padding: 0.75rem 1.5rem; border: none; border-radius: 5px; cursor: not-allowed;">
        Enregistrer (non fonctionnel)
    </button>
</form>
@endsection
