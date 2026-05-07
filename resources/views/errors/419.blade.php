@extends('templates.app')

@section('title', 'Session expirée')

@section('content')
<div style="min-height:60vh; display:flex; align-items:center; justify-content:center; text-align:center; padding:40px 20px">
    <div>
        <div style="font-size:80px; margin-bottom:16px">⏱️</div>
        <h1 style="font-size:clamp(60px,10vw,120px); font-weight:900; margin:0; color:var(--gold); line-height:1">419</h1>
        <p style="font-size:22px; font-weight:700; margin:10px 0 8px">Session expirée</p>
        <p class="muted" style="margin:0 0 28px">Ta session a expiré ou le token de sécurité est invalide.<br>Recharge la page et réessaie.</p>
        <div style="display:flex;gap:12px;justify-content:center;flex-wrap:wrap">
            <button onclick="history.back()" class="btn btn--primary">↩ Revenir en arrière</button>
            <a class="btn" href="{{ route('home') }}">Accueil</a>
        </div>
    </div>
</div>
@endsection
