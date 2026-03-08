@extends('templates.app')

@section('title', 'Modifier mon profil')

@section('content')
<div class="section-header">
    <h1 class="section-title">✏️ Modifier mon profil</h1>
    <a class="btn btn--ghost" href="{{ route('profil') }}">← Retour</a>
</div>

<div style="max-width:500px">
    <div class="card">
        <form method="POST" action="{{ route('profil.update') }}" class="form">
            @csrf

            <div style="display:grid; grid-template-columns:1fr 1fr; gap:12px">
                <div class="field">
                    <label class="label" for="firstname">Prénom</label>
                    <input class="input" type="text" id="firstname" name="firstname"
                           value="{{ old('firstname', Auth::user()->firstname) }}" required>
                    @error('firstname')<span class="small" style="color:#ffaaaa">{{ $message }}</span>@enderror
                </div>
                <div class="field">
                    <label class="label" for="lastname">Nom</label>
                    <input class="input" type="text" id="lastname" name="lastname"
                           value="{{ old('lastname', Auth::user()->lastname) }}" required>
                    @error('lastname')<span class="small" style="color:#ffaaaa">{{ $message }}</span>@enderror
                </div>
            </div>

            <div class="field">
                <label class="label" for="username">Nom d'utilisateur</label>
                <input class="input" type="text" id="username" name="username"
                       value="{{ old('username', Auth::user()->username) }}" required>
                @error('username')<span class="small" style="color:#ffaaaa">{{ $message }}</span>@enderror
            </div>

            <div class="field">
                <label class="label" for="email">E-mail</label>
                <input class="input" type="email" id="email" name="email"
                       value="{{ old('email', Auth::user()->email) }}" required>
                @error('email')<span class="small" style="color:#ffaaaa">{{ $message }}</span>@enderror
            </div>

            <hr style="border-color:var(--border); margin:4px 0">
            <p class="small" style="margin:0">Laisser vide pour ne pas changer le mot de passe</p>

            <div class="field">
                <label class="label" for="password">Nouveau mot de passe</label>
                <input class="input" type="password" id="password" name="password" placeholder="••••••••">
                @error('password')<span class="small" style="color:#ffaaaa">{{ $message }}</span>@enderror
            </div>

            <div class="field">
                <label class="label" for="password_confirmation">Confirmer le mot de passe</label>
                <input class="input" type="password" id="password_confirmation"
                       name="password_confirmation" placeholder="••••••••">
            </div>

            <button class="btn btn--primary" type="submit" style="margin-top:6px">Enregistrer les modifications</button>
        </form>
    </div>
</div>
@endsection
