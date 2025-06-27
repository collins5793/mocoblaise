<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Inscription Admin</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f3f4f6;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .form-container {
            background-color: white;
            padding: 2rem;
            border-radius: 8px;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.1);
            width: 400px;
        }

        .form-container h2 {
            text-align: center;
            margin-bottom: 1.5rem;
        }

        .form-group {
            margin-bottom: 1rem;
        }

        label {
            display: block;
            margin-bottom: 0.3rem;
            font-weight: 500;
        }

        input {
            width: 100%;
            padding: 0.6rem;
            border: 1px solid #ccc;
            border-radius: 6px;
        }

        .btn {
            width: 100%;
            background-color: #2563eb;
            color: white;
            padding: 0.75rem;
            border: none;
            border-radius: 6px;
            font-weight: bold;
            cursor: pointer;
            margin-top: 1rem;
        }

        .btn:hover {
            background-color: #1d4ed8;
        }
    </style>
</head>
<body>
    <div class="form-container">
        <h2>Inscription Admin</h2>
        <form method="POST" action="{{ route('admin.register.submit') }}">
            @csrf

            <div class="form-group">
                <label for="name">Nom complet</label>
                <input type="text" name="name" id="name" required value="{{ old('name') }}">
            </div>

            <div class="form-group">
                <label for="email">Adresse email</label>
                <input type="email" name="email" id="email" required value="{{ old('email') }}">
            </div>

            <div class="form-group">
                <label for="password">Mot de passe</label>
                <input type="password" name="password" id="password" required>
            </div>

            <div class="form-group">
                <label for="password_confirmation">Confirmer mot de passe</label>
                <input type="password" name="password_confirmation" id="password_confirmation" required>
            </div>

            <button type="submit" class="btn">Créer le compte admin</button>
        </form>
    </div>
</body>
</html>
