@extends('templates.app')
@section('title', 'Accueil')
@section('content')
<section class="hero">
    <div class="hero__grid">
        <div class="card">
            <h1 class="h1">Partage tes films préférés avec tes amis</h1>
            <p class="lead">Recherche des films via TMDB, ajoute-les à tes favoris, donne ton avis, puis partage-les avec tes amis.</p>

            @guest
                <div style="display:flex;gap:10px;flex-wrap:wrap;margin-top:14px">
                    <a class="btn btn--primary" href="{{ route('register') }}">Créer un compte 🍿</a>
                    <a class="btn" href="{{ route('login') }}">Se connecter</a>
                </div>
            @endguest
            @auth
                <div style="display:flex;gap:10px;flex-wrap:wrap;margin-top:14px">
                    <a class="btn btn--primary" href="{{ route('films.search') }}">🔍 Rechercher un film</a>
                    <a class="btn" href="{{ route('favoris') }}">⭐ Mes favoris</a>
                </div>
            @endauth

            <div class="badges" style="margin-top:18px">
                <span class="badge">🎬 Laravel</span>
                <span class="badge">🗄️ SQLite / MySQL</span>
                <span class="badge">🎥 API TMDB</span>
                <span class="badge">⭐ Avis & notes</span>
                <span class="badge">👥 Amis & partages</span>
            </div>
        </div>

        <div class="card">
            <p class="small" style="margin:0 0 14px;font-weight:700;color:var(--gold)">✅ Fonctionnalités</p>
            <div style="display:grid;gap:10px">
                @php
                $features = [
                    ['icon'=>'🔐','label'=>'Inscription & connexion sécurisée'],
                    ['icon'=>'🔍','label'=>'Recherche de films (API TMDB)'],
                    ['icon'=>'⭐','label'=>'Gestion des favoris'],
                    ['icon'=>'💬','label'=>'Avis avec note 1-5 étoiles'],
                    ['icon'=>'👥','label'=>'Ajout & gestion des amis'],
                    ['icon'=>'📤','label'=>'Partage de films à ses amis'],
                    ['icon'=>'📥','label'=>'Films partagés reçus'],
                    ['icon'=>'👤','label'=>'Profil utilisateur modifiable'],
                ];
                @endphp
                @foreach($features as $f)
                    <div style="display:flex;align-items:center;gap:10px;font-size:14px">
                        <span style="font-size:18px">{{ $f['icon'] }}</span>
                        <span style="color:var(--muted)">{{ $f['label'] }}</span>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</section>

@auth
{{-- Stats rapides --}}
@php
$nbFavoris  = \App\Models\Favori::where('user_id', Auth::id())->count();
$nbAmis     = \App\Models\Ami::where('user_id', Auth::id())->count();
$nbPartages = \App\Models\Partage::where('user_id', Auth::id())->count();
$nbRecus    = \App\Models\Partage::where('ami_id', Auth::id())->count();
@endphp
<div style="display:grid;grid-template-columns:repeat(4,1fr);gap:12px;margin-top:18px">
    <a href="{{ route('favoris') }}" class="stat-card">
        <div class="stat-card__num" style="color:var(--gold)">{{ $nbFavoris }}</div>
        <div class="stat-card__label">Favoris</div>
    </a>
    <a href="{{ route('amis') }}" class="stat-card">
        <div class="stat-card__num" style="color:#a78bfa">{{ $nbAmis }}</div>
        <div class="stat-card__label">Amis</div>
    </a>
    <a href="{{ route('partages') }}" class="stat-card">
        <div class="stat-card__num" style="color:var(--ok)">{{ $nbPartages }}</div>
        <div class="stat-card__label">Partages envoyés</div>
    </a>
    <a href="{{ route('partages') }}" class="stat-card">
        <div class="stat-card__num" style="color:var(--primary)">{{ $nbRecus }}</div>
        <div class="stat-card__label">Films reçus</div>
    </a>
</div>
@endauth
@endsection
