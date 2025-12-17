@extends('templates.app')

@section('title', 'Connexion - Mes Films Préférés')

@section('content')
<div class="auth-form-container">
    <div class="auth-form">
        <h1>🔐 Se connecter</h1>
        <p class="auth-subtitle">Bienvenue sur Mes Films Préférés !</p>

        <form method="POST" action="{{ route('login.store') }}" class="form">
            @csrf

            <!-- Email -->
            <div class="form-group">
                <label for="email" class="form-label">Email</label>
                <input 
                    type="email" 
                    name="email" 
                    id="email" 
                    class="form-input @error('email') is-invalid @enderror"
                    value="{{ old('email') }}"
                    required
                    autofocus
                >
                @error('email')
                    <span class="error-message">{{ $message }}</span>
                @enderror
            </div>

            <!-- Mot de passe -->
            <div class="form-group">
                <label for="password" class="form-label">Mot de passe</label>
                <input 
                    type="password" 
                    name="password" 
                    id="password" 
                    class="form-input @error('password') is-invalid @enderror"
                    required
                >
                @error('password')
                    <span class="error-message">{{ $message }}</span>
                @enderror
            </div>

            <!-- Bouton submit -->
            <button type="submit" class="btn btn-primary btn-full">🏗️ Se connecter</button>
        </form>

        <!-- Lien vers register -->
        <p class="auth-footer">
            Pas encore inscrit ? <a href="{{ route('register') }}">Créer un compte</a>
        </p>
    </div>
</div>
@endsection
