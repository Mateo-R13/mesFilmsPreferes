@extends('templates.app')
@section('title', 'Accueil')
@section('content')

{{-- Bannière de bienvenue pour un utilisateur invité --}}
@if(session('invited_by'))
<div style="
    background: linear-gradient(135deg, rgba(229,9,20,.15), rgba(246,196,83,.10));
    border: 1px solid rgba(246,196,83,.40);
    border-radius: 18px;
    padding: 22px 26px;
    margin-bottom: 24px;
    display: flex;
    align-items: flex-start;
    gap: 18px;
    animation: fadeUp .5s ease both;
">
    <div style="font-size:42px;flex-shrink:0;line-height:1">🎞️</div>
    <div style="flex:1">
        <div style="font-size:18px;font-weight:800;margin-bottom:6px">
            Bienvenue sur MesFilmsPréférés, {{ Auth::user()->firstname }} ! 🍿
        </div>
        <div style="color:var(--muted);font-size:14px;margin-bottom:{{ session('invited_message') ? '10px' : '0' }}">
            Vous avez été invité(e) par <strong style="color:var(--gold)">{{ session('invited_by') }}</strong>.
            Explorez l’application et ajoutez vos premiers films favoris !
        </div>
        @if(session('invited_message'))
        <div style="
            padding: 10px 14px;
            background: rgba(246,196,83,.08);
            border: 1px solid rgba(246,196,83,.22);
            border-radius: 10px;
            font-size: 13px;
            color: var(--muted);
            font-style: italic;
        ">
            “{{ session('invited_message') }}”
        </div>
        @endif
    </div>
</div>
@endif

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
                    <a class="btn btn--primary" href="{{ route('films.search') }}">&#x1F50D; Rechercher un film</a>
                    <a class="btn" href="{{ route('favoris') }}">&#x2B50; Mes favoris</a>
                </div>
            @endauth

            <div class="badges" style="margin-top:18px">
                <span class="badge">🎦 Laravel</span>
                <span class="badge">🗄️ SQLite / MySQL</span>
                <span class="badge">🎥 API TMDB</span>
                <span class="badge">⭐ Avis &amp; notes</span>
                <span class="badge">👥 Amis &amp; partages</span>
            </div>
        </div>

        <div class="card">
            <p class="small" style="margin:0 0 14px;font-weight:700;color:var(--gold)">✅ Fonctionnalités</p>
            <div style="display:grid;gap:10px">
                @php
                $features = [
                    ['icon'=>'🔐','label'=>'Inscription &amp; connexion sécurisée'],
                    ['icon'=>'🔍','label'=>'Recherche de films (API TMDB)'],
                    ['icon'=>'⭐','label'=>'Gestion des favoris'],
                    ['icon'=>'💬','label'=>'Avis avec note 1-5 étoiles'],
                    ['icon'=>'👥','label'=>'Ajout &amp; gestion des amis'],
                    ['icon'=>'📤','label'=>'Partage de films à ses amis'],
                    ['icon'=>'📥','label'=>'Films partagés reçus'],
                    ['icon'=>'👤','label'=>'Profil utilisateur modifiable'],
                    ['icon'=>'✉️','label'=>'Invitations de nouveaux membres'],
                ];
                @endphp
                @foreach($features as $f)
                    <div style="display:flex;align-items:center;gap:10px;font-size:14px">
                        <span style="font-size:18px">{!! $f['icon'] !!}</span>
                        <span style="color:var(--muted)">{!! $f['label'] !!}</span>
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
