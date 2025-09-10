@extends('layouts.guest')

@section('content')
    <div class="text-center mt-10">
        <h1 class="text-2xl font-bold text-green-600">Inscription réussie !</h1>
        <p class="mt-4">Votre compte a été créé avec succès. Vous pouvez maintenant vous connecter.</p>
        <a href="{{ route('login') }}" class="mt-6 inline-block px-6 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
            Se connecter
        </a>
    </div>
@endsection
