<!DOCTYPE html>
<html lang="fr">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Connexion - MoCoBlaise</title>
  <link rel="stylesheet" href="{{ asset('css/auth.css') }}">
  <style>
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
    }

    body {
      font-family: 'Segoe UI', sans-serif;
      background: #000;
      height: 100vh;
      display: flex;
      align-items: center;
      justify-content: center;
      color: #fff;
    }

    .auth-container {
      width: 900px;
      height: 500px;
      perspective: 1500px;
    }

    .flip-card {
      width: 100%;
      height: 100%;
      position: relative;
      transform-style: preserve-3d;
      transition: transform 0.8s ease-in-out;
    }

    .auth-container.show-signup .flip-card {
      transform: rotateY(180deg);
    }

    .auth-face {
      width: 100%;
      height: 100%;
      position: absolute;
      top: 0;
      left: 0;
      backface-visibility: hidden;
      display: flex;
      border-radius: 10px;
      overflow: hidden;
      box-shadow: 0 0 30px #00bfff80;
    }

    .front, .back {
      background: #0c0c1b;
    }

    .back {
      transform: rotateY(180deg);
    }

    .form-section, .form-section2 {
      flex: 1;
      padding: 50px;
      background-color: #0c0c1b;
    }

    .welcome-section {
      flex: 1;
      background: #00bfff;
      clip-path: polygon(0% 0%, 100% 0, 100% 100%, 50% 100%);
      display: flex;
      justify-content: center;
      align-items:flex-start;  
      color: white;
    }
    .welcome-section2 {
      flex: 1;
      background: #00bfff;
      clip-path: polygon(0% 0, 100% 0, 50% 100%, 0% 100%);
      display: flex;
      justify-content: center;
      align-items: flex-start;
      color: white;
    }

    .welcome-text {
      text-align:end;
      padding: 40px;
    }
    .welcome-text2 {
      text-align:start;
      padding: 40px;
    }

    h2 {
      font-size: 2rem;
      margin-bottom: 30px;
    }

    .input-group {
      margin-bottom: 20px;
    }

    .input-group label {
      font-size: 14px;
      color: #00bfff;
      margin-bottom: 5px;
      display: block;
    }

    .input-field {
      position: relative;
    }

    .input-field input {
      width: 100%;
      padding: 10px 35px 10px 10px;
      background: transparent;
      border: none;
      border-bottom: 2px solid #00bfff;
      color: #fff;
      font-size: 16px;
    }

    .icon {
      position: absolute;
      right: 10px;
      top: 8px;
      font-size: 18px;
    }

    .auth-btn {
      background: linear-gradient(90deg, #00bfff, #009acd);
      border: none;
      color: white;
      padding: 12px;
      font-size: 16px;
      border-radius: 30px;
      cursor: pointer;
      margin-top: 20px;
      width: 100%;
    }

    .switch-text {
      margin-top: 15px;
      font-size: 14px;
      color: #aaa;
      text-align: center;
    }

    .switch-text a {
      color: #00bfff;
      text-decoration: none;
      cursor: pointer;
    }
  </style>
</head>

<body>
  <div class="auth-container" id="authContainer">
    <div class="flip-card">

      <!-- Connexion -->
      <div class="auth-face front">
        <div class="form-section">
          <h2>Connexion</h2>
          <form method="POST" action="{{ route('login') }}">
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

            <div class="input-group">
              <label for="email">Email</label>
              <div class="input-field">
                <input type="email" id="email" name="email" value="{{ old('email') }}" placeholder="Entrer votre email" required />
                <span class="icon">📧</span>
              </div>
            </div>

            <div class="input-group">
              <label for="password">Mot de passe</label>
              <div class="input-field">
                <input type="password" id="password" name="password" placeholder="Mot de passe" required />
                <span class="icon">🔒</span>
              </div>
            </div>

            <button type="submit" class="auth-btn">Se connecter</button>
            <a href="{{ route('google.redirect') }}" class="auth-btn" style="background: #ea4335; text-align: center; display: block; text-decoration: none; margin-top: 10px;">Connexion avec Google</a>
          </form>
          <p class="switch-text">Pas encore de compte ? <a onclick="toggleForm()">Créer un compte</a></p>
        </div>
        <div class="welcome-section">
          <div class="welcome-text">
            <h1>Bienvenue !</h1>
            <p>Connectez-vous pour accéder à la plateforme</p>
          </div>
        </div>
      </div>

      <!-- Inscription -->
      <div class="auth-face back">
        <div class="welcome-section2">
          <div class="welcome-text2">
            <h1>Bienvenue !</h1>
            <p>Rejoignez-nous et commencez votre parcours d'apprentissage</p>
          </div>
        </div>
        <div class="form-section2">
          <h2>Créer un compte</h2>
          <form method="POST" action="{{ route('register') }}">
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

            <div class="input-group">
              <label for="name">Nom</label>
              <div class="input-field">
                <input type="text" id="name" name="name" value="{{ old('name') }}" placeholder="Votre nom" required />
                <span class="icon">👤</span>
              </div>
            </div>

            <div class="input-group">
              <label for="email">Email</label>
              <div class="input-field">
                <input type="email" id="email" name="email" value="{{ old('email') }}" placeholder="Votre email" required />
                <span class="icon">📧</span>
              </div>
            </div>

            <div class="input-group">
              <label for="password">Mot de passe</label>
              <div class="input-field">
                <input type="password" id="password" name="password" placeholder="Mot de passe" required />
                <span class="icon">🔒</span>
              </div>
            </div>

            <div class="input-group">
              <label for="password_confirmation">Confirmer</label>
              <div class="input-field">
                <input type="password" id="password_confirmation" name="password_confirmation" placeholder="Confirmez le mot de passe" required />
                <span class="icon">🔒</span>
              </div>
            </div>

            <button type="submit" class="auth-btn">S'inscrire</button>
          </form>
          <p class="switch-text">Déjà inscrit ? <a onclick="toggleForm()">Se connecter</a></p>
        </div>
      </div>

    </div>
  </div>

  <script src="{{ asset('js/auth.js') }}"></script>
  <script>
    function toggleForm() {
      document.getElementById('authContainer').classList.toggle('show-signup');
    }
  </script>
</body>

</html>
