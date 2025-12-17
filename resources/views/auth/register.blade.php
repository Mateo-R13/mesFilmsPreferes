@extends('templates.app')

@section('title', 'Créer un compte - Mes Films Préférés')

@section('content')
<div class="auth-form-container">
    <div class="auth-form">
        <h1>📜 Créer un compte</h1>
        <p class="auth-subtitle">Rejoignez notre communauté de cinéphiles !</p>

        <form method="POST" action="{{ route('register.store') }}" class="form">
            @csrf

            <!-- Prénom -->
            <div class="form-group">
                <label for="firstname" class="form-label">Prénom</label>
                <input 
                    type="text" 
                    name="firstname" 
                    id="firstname" 
                    class="form-input @error('firstname') is-invalid @enderror"
                    value="{{ old('firstname') }}"
                    required
                >
                @error('firstname')
                    <span class="error-message">{{ $message }}</span>
                @enderror
            </div>

            <!-- Nom -->
            <div class="form-group">
                <label for="lastname" class="form-label">Nom</label>
                <input 
                    type="text" 
                    name="lastname" 
                    id="lastname" 
                    class="form-input @error('lastname') is-invalid @enderror"
                    value="{{ old('lastname') }}"
                    required
                >
                @error('lastname')
                    <span class="error-message">{{ $message }}</span>
                @enderror
            </div>

            <!-- Nom d'utilisateur -->
            <div class="form-group">
                <label for="username" class="form-label">Nom d'utilisateur</label>
                <input 
                    type="text" 
                    name="username" 
                    id="username" 
                    class="form-input @error('username') is-invalid @enderror"
                    value="{{ old('username') }}"
                    required
                >
                @error('username')
                    <span class="error-message">{{ $message }}</span>
                @enderror
            </div>

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

            <!-- Confirmation mot de passe -->
            <div class="form-group">
                <label for="password_confirmation" class="form-label">Confirmer le mot de passe</label>
                <input 
                    type="password" 
                    name="password_confirmation" 
                    id="password_confirmation" 
                    class="form-input"
                    required
                >
            </div>

            <!-- Bouton submit -->
            <button type="submit" class="btn btn-primary btn-full">🏗️ Créer mon compte</button>
        </form>

        <!-- Lien vers login -->
        <p class="auth-footer">
            Déjà inscrit ? <a href="{{ route('login') }}">Se connecter</a>
        </p>
    </div>
</div>
@endsection
