<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Portail d'inscription et paiement</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f3f4f6;
            text-align: center;
            padding: 50px;
        }
        h1 { font-size: 2.5rem; margin-bottom: 10px; }
        p { font-size: 1.2rem; margin-bottom: 20px; }
        a, button {
            display: inline-block;
            padding: 10px 20px;
            margin: 5px;
            font-size: 1rem;
            text-decoration: none;
            border-radius: 5px;
            color: white;
            border: none;
            cursor: pointer;
        }
        .blue { background-color: #2563eb; }
        .blue:hover { background-color: #1d4ed8; }
        .green { background-color: #16a34a; }
        .green:hover { background-color: #15803d; }
        .purple { background-color: #7c3aed; }
        .purple:hover { background-color: #6d28d9; }
        .gray { background-color: #4b5563; }
        .gray:hover { background-color: #374151; }
        .red { background-color: #dc2626; }
        .red:hover { background-color: #b91c1c; }
        form { display: inline-block; margin: 5px; }
    </style>
</head>
<body>

    <h1>Bienvenue sur le portail</h1>
    <p>Gérez les inscriptions, paiements et utilisateurs selon votre rôle.</p>

    @if (Route::has('login'))
        @auth
            @php $role = Auth::user()->role; @endphp

            @if ($role === 'etudiant')
                <a href="{{ route('etudiant.dashboard') }}" class="blue">Dashboard Étudiant</a>
            @elseif ($role === 'admin' || $role === 'administration')
                <a href="{{ route('administration.dashboard') }}" class="green">Dashboard Administration</a>
            @elseif ($role === 'comptable')
                <a href="{{ route('comptable.dashboard') }}" class="purple">Dashboard Comptable</a>
            @else
                <a href="{{ url('/dashboard') }}" class="gray">Dashboard</a>
            @endif

            <form method="POST" action="{{ route('logout-web') }}">
                   @csrf
                   <button type="submit">Se déconnecter</button>
             </form>

        @else
            <a href="{{ route('login') }}" class="blue">Se connecter</a>
            @if (Route::has('register'))
                <a href="{{ route('register') }}" class="green">S'inscrire</a>
            @endif
        @endauth
    @endif

</body>
</html>
