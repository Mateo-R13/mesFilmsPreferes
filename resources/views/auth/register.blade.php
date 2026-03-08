@extends('templates.app')

@section('title', 'Créer un compte')

@section('content')
<div class="auth-page">
    <div class="auth-box" style="max-width:500px">
        <div class="card">
            <h1 class="auth-title">Créer un compte</h1>
            <p class="auth-sub">Rejoins la communauté et partage tes films !</p>

            <form method="POST" action="{{ route('register.store') }}" class="form">
                @csrf

                <div style="display:grid; grid-template-columns:1fr 1fr; gap:12px">
                    <div class="field">
                        <label class="label" for="firstname">Prénom</label>
                        <input class="input" type="text" id="firstname" name="firstname"
                               value="{{ old('firstname') }}" required placeholder="Jean">
                        @error('firstname')<span class="small" style="color:#ffaaaa">{{ $message }}</span>@enderror
                    </div>
                    <div class="field">
                        <label class="label" for="lastname">Nom</label>
                        <input class="input" type="text" id="lastname" name="lastname"
                               value="{{ old('lastname') }}" required placeholder="Dupont">
                        @error('lastname')<span class="small" style="color:#ffaaaa">{{ $message }}</span>@enderror
                    </div>
                </div>

                <div class="field">
                    <label class="label" for="username">Nom d'utilisateur</label>
                    <input class="input" type="text" id="username" name="username"
                           value="{{ old('username') }}" required placeholder="jean_dupont">
                    @error('username')<span class="small" style="color:#ffaaaa">{{ $message }}</span>@enderror
                </div>

                <div class="field">
                    <label class="label" for="email">Adresse e-mail</label>
                    <input class="input" type="email" id="email" name="email"
                           value="{{ old('email') }}" required placeholder="jean@mail.fr">
                    @error('email')<span class="small" style="color:#ffaaaa">{{ $message }}</span>@enderror
                </div>

                <div class="field">
                    <label class="label" for="password">Mot de passe <span class="muted">(min. 8 caractères)</span></label>
                    <input class="input" type="password" id="password" name="password"
                           required placeholder="••••••••">
                    @error('password')<span class="small" style="color:#ffaaaa">{{ $message }}</span>@enderror
                </div>

                <div class="field">
                    <label class="label" for="password_confirmation">Confirmer le mot de passe</label>
                    <input class="input" type="password" id="password_confirmation"
                           name="password_confirmation" required placeholder="••••••••">
                </div>

                <button class="btn btn--primary" type="submit" style="margin-top:6px">Créer mon compte</button>
            </form>

            <p class="small" style="margin-top:20px; text-align:center">
                Déjà un compte ?
                <a href="{{ route('login') }}" style="color:var(--gold)">Se connecter</a>
            </p>
        </div>
    </div>
</div>
@endsection
