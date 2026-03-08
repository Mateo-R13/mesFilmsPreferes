@extends('templates.app')

@section('title', 'Accueil')

@section('content')
<section class="hero">
    <div class="hero__grid">
        <div class="card">
            <h1 class="h1">Partage tes films<br>préférés avec tes amis</h1>
            <p class="lead">Recherche des films via TMDB, ajoute-les à tes favoris, donne ton avis, puis partage-les individuellement à tes amis.</p>

            @guest
                <div style="display:flex; gap:10px; flex-wrap:wrap; margin-top:14px">
                    <a class="btn btn--primary" href="{{ route('register') }}">Créer un compte</a>
                    <a class="btn" href="{{ route('login') }}">Se connecter</a>
                </div>
            @endguest

            @auth
                <div style="display:flex; gap:10px; flex-wrap:wrap; margin-top:14px">
                    <a class="btn btn--primary" href="{{ route('films.search') }}">🎬 Rechercher un film</a>
                    <a class="btn" href="{{ route('favoris') }}">⭐ Mes favoris</a>
                </div>
            @endauth

            <div class="badges">
                <span class="badge">Laravel</span>
                <span class="badge">MySQL</span>
                <span class="badge">API TMDB</span>
                <span class="badge">Favoris & avis</span>
                <span class="badge">Amis & partages</span>
            </div>
        </div>

        <div class="card card--flat">
            <p class="small" style="margin:0 0 14px; font-weight:600; color:var(--gold)">Fonctionnalités du site</p>
            <div class="small" style="display:grid; gap:10px">
                <div>🔐 Créer un compte et se connecter</div>
                <div>🔍 Rechercher des films (API TMDB)</div>
                <div>⭐ Ajouter un film à ses favoris</div>
                <div>✍️ Donner un avis sur ses favoris</div>
                <div>👥 Voir les autres utilisateurs</div>
                <div>🤝 Ajouter ou retirer des amis</div>
                <div>📤 Partager un favori à un ami</div>
                <div>📥 Voir les films partagés avec moi</div>
            </div>
        </div>
    </div>
</section>
@endsection
