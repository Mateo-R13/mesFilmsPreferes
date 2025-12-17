@extends('templates.app')

@section('title', 'Bienvenue - Mes Films Préférés')

@section('content')
<div class="hero-section">
    <div class="hero-content">
        <h1>Bienvenue sur Mes Films Préférés 🎬</h1>
        <p>Partagez vos films préférés avec vos amis !</p>
        <p>Recherchez des films, ajoutez vos favoris, donnez votre avis et partagez-les avec votre communauté.</p>

        <div class="cta-buttons">
            <a href="{{ route('login') }}" class="btn btn-primary">Se connecter</a>
            <a href="{{ route('register') }}" class="btn btn-secondary">Créer un compte</a>
        </div>
    </div>
</div>

<section class="features-section">
    <h2>Ce que vous pouvez faire</h2>
    <div class="features-grid">
        <div class="feature-card">
            <div class="feature-icon">🔍</div>
            <h3>Rechercher</h3>
            <p>Parcourez la base de données TMDB pour trouver n'importe quel film.</p>
        </div>
        <div class="feature-card">
            <div class="feature-icon">❤️</div>
            <h3>Marquer comme favori</h3>
            <p>Créez votre liste personnelle de films préférés.</p>
        </div>
        <div class="feature-card">
            <div class="feature-icon">📚</div>
            <h3>Donner votre avis</h3>
            <p>Notez et commentez vos films favoris (1-5 étoiles).</p>
        </div>
        <div class="feature-card">
            <div class="feature-icon">👥</div>
            <h3>Ajouter des amis</h3>
            <p>Connectez-vous avec d'autres fans de cinéma.</p>
        </div>
        <div class="feature-card">
            <div class="feature-icon">🎁</div>
            <h3>Partager</h3>
            <p>Envoyez vos films favoris à vos amis.</p>
        </div>
        <div class="feature-card">
            <div class="feature-icon">👤</div>
            <h3>Profil</h3>
            <p>Gérez votre profil et vos préférences.</p>
        </div>
    </div>
</section>
@endsection
