@extends('templates.app')
@section('title', 'Connexion')
@section('content')
<div class="auth-card">
    <div class="card">
        <div style="text-align:center;margin-bottom:24px">
            <div style="font-size:40px">🎬</div>
            <h1 class="auth-title">Connexion</h1>
            <p class="small">Content de te revoir !</p>
        </div>

        <form method="POST" action="{{ route('login.store') }}" class="form">
            @csrf
            <div>
                <label class="label">Email</label>
                <input class="input {{ $errors->has('email') ? 'input--error' : '' }}"
                       type="email" name="email"
                       value="{{ old('email') }}"
                       placeholder="ton@email.fr" autofocus required>
                @error('email')<div class="field-error">{{ $message }}</div>@enderror
            </div>
            <div>
                <label class="label">Mot de passe</label>
                <input class="input {{ $errors->has('password') ? 'input--error' : '' }}"
                       type="password" name="password"
                       placeholder="••••••••" required>
                @error('password')<div class="field-error">{{ $message }}</div>@enderror
            </div>

            @if($errors->any() && !$errors->has('email') && !$errors->has('password'))
                <div class="alert alert--err">{{ $errors->first() }}</div>
            @endif

            <button class="btn btn--primary" type="submit" style="width:100%;padding:13px">Se connecter</button>
        </form>

        <p class="small" style="text-align:center;margin-top:18px">
            Pas encore de compte ?
            <a href="{{ route('register') }}" style="color:var(--gold);font-weight:700">Créer un compte</a>
        </p>
    </div>
</div>
@endsection
