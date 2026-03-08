@extends('templates.app')

@section('title', 'Accès refusé')

@section('content')
<div style="min-height:60vh; display:flex; align-items:center; justify-content:center; text-align:center; padding:40px 20px">
    <div>
        <div style="font-size:80px; margin-bottom:16px">🔒</div>
        <h1 style="font-size:clamp(60px,10vw,120px); font-weight:900; margin:0; color:var(--primary); line-height:1">403</h1>
        <p style="font-size:22px; font-weight:700; margin:10px 0 8px">Accès refusé</p>
        <p class="muted" style="margin:0 0 28px">Tu n'as pas la permission d'accéder à cette page.</p>
        <a class="btn btn--primary" href="{{ route('home') }}">← Retour à l'accueil</a>
    </div>
</div>
@endsection
