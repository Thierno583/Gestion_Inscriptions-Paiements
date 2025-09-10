<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inscription</title>
    <link rel="stylesheet" href="{{ asset('css/login.css') }}">
</head>
<body>
    <div class="login-container">
        <div class="login-card">

            {{-- Logo + titre --}}
            <div class="login-header">
                <img src="{{ asset('images/logo.png') }}" alt="Logo" class="login-logo">
                <h2>Inscription au Portail</h2>
            </div>

            <form method="POST" action="{{ route('register') }}">
                @csrf

                {{-- Nom --}}
                <div class="form-group">
                    <label for="name">Nom</label>
                    <input id="name" type="text" name="name" value="{{ old('name') }}" required autofocus>
                    @error('name')
                        <span class="error-message">{{ $message }}</span>
                    @enderror
                </div>

                {{-- Email --}}
                <div class="form-group">
                    <label for="email">Adresse e-mail</label>
                    <input id="email" type="email" name="email" value="{{ old('email') }}" required>
                    @error('email')
                        <span class="error-message">{{ $message }}</span>
                    @enderror
                </div>

                {{-- Mot de passe --}}
                <div class="form-group">
                    <label for="password">Mot de passe</label>
                    <input id="password" type="password" name="password" required>
                    @error('password')
                        <span class="error-message">{{ $message }}</span>
                    @enderror
                </div>

                {{-- Confirmation mot de passe --}}
                <div class="form-group">
                    <label for="password-confirm">Confirmer le mot de passe</label>
                    <input id="password-confirm" type="password" name="password_confirmation" required>
                </div>

                {{-- Type de compte --}}
                <div class="form-group">
                    <label for="account_type">Type de compte</label>
                    <select id="account_type" name="account_type" required>
                        <option value="">-- Sélectionnez --</option>
                        <option value="etudiant" {{ old('account_type') == 'etudiant' ? 'selected' : '' }}>Étudiant</option>
                        <option value="admin" {{ old('account_type') == 'admin' ? 'selected' : '' }}>Administrateur</option>
                        <option value="comptable" {{ old('account_type') == 'comptable' ? 'selected' : '' }}>Comptable</option>
                    </select>
                    @error('account_type')
                        <span class="error-message">{{ $message }}</span>
                    @enderror
                </div>

                {{-- Bouton --}}
                <button type="submit" class="btn-login">S'inscrire</button>

                <p class="register-link">
                    Déjà inscrit ? <a href="{{ route('login') }}">Se connecter</a>
                </p>
            </form>
        </div>
    </div>
</body>
</html>
