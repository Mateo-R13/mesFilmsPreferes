@extends('templates.app')

@section('title', 'Connexion')

@section('content')
<div class="auth-page">
    <div class="auth-box">
        <div class="card">
            <h1 class="auth-title">Connexion</h1>
            <p class="auth-sub">Accède à tes films préférés et partages.</p>

            <form method="POST" action="{{ route('login.store') }}" class="form">
                @csrf

                <div class="field">
                    <label class="label" for="email">Adresse e-mail</label>
                    <input class="input" type="email" id="email" name="email"
                           value="{{ old('email') }}" required autofocus
                           placeholder="exemple@mail.fr">
                    @error('email')
                        <span class="small" style="color:#ffaaaa">{{ $message }}</span>
                    @enderror
                </div>

                <div class="field">
                    <label class="label" for="password">Mot de passe</label>
                    <input class="input" type="password" id="password" name="password"
                           required placeholder="••••••••">
                    @error('password')
                        <span class="small" style="color:#ffaaaa">{{ $message }}</span>
                    @enderror
                </div>

                <button class="btn btn--primary" type="submit" style="margin-top:6px">Se connecter</button>
            </form>

            <p class="small" style="margin-top:20px; text-align:center">
                Pas encore de compte ?
                <a href="{{ route('register') }}" style="color:var(--gold)">Créer un compte</a>
            </p>
        </div>
    </div>
</div>
@endsection
