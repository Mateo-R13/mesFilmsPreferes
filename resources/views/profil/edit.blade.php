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

    {{-- Zone suppression de compte --}}
    <div class="card" style="margin-top:24px;border:1px solid rgba(200,50,50,0.3)">
        <h2 style="font-size:1rem;font-weight:700;color:#e05555;margin-bottom:8px">🗑️ Supprimer mon compte</h2>
        <p class="small" style="margin-bottom:16px;color:var(--muted)">Cette action est irréversible. Tous tes favoris, avis, amis et partages seront supprimés.</p>

        <button class="btn" style="background:rgba(200,50,50,0.1);color:#e05555;border:1px solid rgba(200,50,50,0.3)"
            onclick="document.getElementById('delete-modal').style.display='flex'">
            Supprimer mon compte
        </button>
    </div>
</div>

{{-- Modal confirmation --}}
<div id="delete-modal" style="display:none;position:fixed;inset:0;background:rgba(0,0,0,0.6);z-index:999;align-items:center;justify-content:center">
    <div class="card" style="max-width:400px;width:90%;padding:28px">
        <h3 style="font-size:1.1rem;font-weight:700;margin-bottom:8px">⚠️ Confirmer la suppression</h3>
        <p class="small" style="margin-bottom:16px;color:var(--muted)">Saisis ton mot de passe pour confirmer la suppression définitive de ton compte.</p>

        <form method="POST" action="{{ route('profil.delete') }}">
            @csrf
            @method('DELETE')
            <div style="margin-bottom:14px">
                <label class="label">Mot de passe</label>
                <input class="input" type="password" name="password" required autocomplete="current-password">
                @error('password')<div class="field-error">{{ $message }}</div>@enderror
            </div>
            <div style="display:flex;gap:10px">
                <button type="button" class="btn btn--ghost" style="flex:1"
                    onclick="document.getElementById('delete-modal').style.display='none'">
                    Annuler
                </button>
                <button type="submit" class="btn" style="flex:1;background:#c83232;color:#fff;border:none">
                    Oui, supprimer
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
