@extends('templates.app')

@section('title', 'Page introuvable')

@section('content')
<div style="min-height:60vh; display:flex; align-items:center; justify-content:center; text-align:center; padding:40px 20px">
    <div>
        <div style="font-size:80px; margin-bottom:16px">🎬</div>
        <h1 style="font-size:clamp(60px,10vw,120px); font-weight:900; margin:0; color:var(--primary); line-height:1">404</h1>
        <p style="font-size:22px; font-weight:700; margin:10px 0 8px">Cette page n'existe pas</p>
        <p class="muted" style="margin:0 0 28px">Le film que tu cherches s'est peut-être enfui du cinéma.</p>
        <div style="display:flex; gap:12px; justify-content:center; flex-wrap:wrap">
            <a class="btn btn--primary" href="{{ route('home') }}">← Retour à l'accueil</a>
            <a class="btn" href="{{ route('films.search') }}">Rechercher un film</a>
        </div>
    </div>
</div>
@endsection
