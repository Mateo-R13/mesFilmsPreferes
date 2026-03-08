@extends('templates.app')
@section('title', 'Créer un compte')
@section('content')
<div class="auth-card">
    <div class="card">
        <div style="text-align:center;margin-bottom:24px">
            <div style="font-size:40px">🍿</div>
            <h1 class="auth-title">Créer un compte</h1>
            <p class="small">Rejoins la communauté cinéphile !</p>
        </div>

        <form method="POST" action="{{ route('register.store') }}" class="form">
            @csrf
            <div style="display:grid;grid-template-columns:1fr 1fr;gap:12px">
                <div>
                    <label class="label">Prénom</label>
                    <input class="input {{ $errors->has('firstname') ? 'input--error' : '' }}"
                           type="text" name="firstname"
                           value="{{ old('firstname') }}"
                           placeholder="Marie" required>
                    @error('firstname')<div class="field-error">{{ $message }}</div>@enderror
                </div>
                <div>
                    <label class="label">Nom</label>
                    <input class="input {{ $errors->has('lastname') ? 'input--error' : '' }}"
                           type="text" name="lastname"
                           value="{{ old('lastname') }}"
                           placeholder="Dupont" required>
                    @error('lastname')<div class="field-error">{{ $message }}</div>@enderror
                </div>
            </div>
            <div>
                <label class="label">Nom d'utilisateur</label>
                <input class="input {{ $errors->has('username') ? 'input--error' : '' }}"
                       type="text" name="username"
                       value="{{ old('username') }}"
                       placeholder="marie_d" required>
                @error('username')<div class="field-error">{{ $message }}</div>@enderror
            </div>
            <div>
                <label class="label">Email</label>
                <input class="input {{ $errors->has('email') ? 'input--error' : '' }}"
                       type="email" name="email"
                       value="{{ old('email') }}"
                       placeholder="ton@email.fr" required>
                @error('email')<div class="field-error">{{ $message }}</div>@enderror
            </div>
            <div>
                <label class="label">Mot de passe</label>
                <input class="input {{ $errors->has('password') ? 'input--error' : '' }}"
                       type="password" name="password"
                       placeholder="8 caractères minimum" required>
                @error('password')<div class="field-error">{{ $message }}</div>@enderror
            </div>
            <div>
                <label class="label">Confirmer le mot de passe</label>
                <input class="input" type="password" name="password_confirmation"
                       placeholder="••••••••" required>
            </div>

            <button class="btn btn--primary" type="submit" style="width:100%;padding:13px">Créer mon compte 🎬</button>
        </form>

        <p class="small" style="text-align:center;margin-top:18px">
            Déjà un compte ?
            <a href="{{ route('login') }}" style="color:var(--gold);font-weight:700">Se connecter</a>
        </p>
    </div>
</div>
@endsection
