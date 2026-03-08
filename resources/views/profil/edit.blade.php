@extends('templates.app')
@section('title', 'Modifier mon profil')
@section('content')
<div style="max-width:520px;margin:0 auto">
    <div class="section-header">
        <h1 class="section-title">✏️ Modifier mon profil</h1>
        <a class="btn btn--ghost" href="{{ route('profil') }}">← Retour</a>
    </div>

    <div class="card">
        <form method="POST" action="{{ route('profil.update') }}">
            @csrf
            <div style="display:grid;grid-template-columns:1fr 1fr;gap:14px;margin-bottom:14px">
                <div>
                    <label class="label">Prénom</label>
                    <input class="input" type="text" name="firstname" value="{{ old('firstname', $user->firstname) }}" required>
                    @error('firstname')<div class="field-error">{{ $message }}</div>@enderror
                </div>
                <div>
                    <label class="label">Nom</label>
                    <input class="input" type="text" name="lastname" value="{{ old('lastname', $user->lastname) }}" required>
                    @error('lastname')<div class="field-error">{{ $message }}</div>@enderror
                </div>
            </div>
            <div style="margin-bottom:14px">
                <label class="label">Nom d'utilisateur</label>
                <input class="input" type="text" name="username" value="{{ old('username', $user->username) }}" required>
                @error('username')<div class="field-error">{{ $message }}</div>@enderror
            </div>
            <div style="margin-bottom:14px">
                <label class="label">Email</label>
                <input class="input" type="email" name="email" value="{{ old('email', $user->email) }}" required>
                @error('email')<div class="field-error">{{ $message }}</div>@enderror
            </div>
            <hr style="border-color:var(--border);margin:16px 0">
            <p class="small" style="margin:0 0 10px">Laisser vide pour ne pas changer le mot de passe</p>
            <div style="margin-bottom:14px">
                <label class="label">Nouveau mot de passe</label>
                <input class="input" type="password" name="password" autocomplete="new-password">
                @error('password')<div class="field-error">{{ $message }}</div>@enderror
            </div>
            <div style="margin-bottom:20px">
                <label class="label">Confirmer le mot de passe</label>
                <input class="input" type="password" name="password_confirmation" autocomplete="new-password">
            </div>
            <button class="btn btn--primary" type="submit" style="width:100%">Enregistrer les modifications</button>
        </form>
    </div>
</div>
@endsection
