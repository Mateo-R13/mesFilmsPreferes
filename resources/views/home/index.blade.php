@extends('templates.app')

@section('title', 'Accueil - Mes Films Préférés')

@section('content')
<div class="dashboard-section">
    <h1>Bienvenue {{ $user->firstname }} ! 👋</h1>

    <!-- Cartes de statistiques -->
    <div class="stats-grid">
        <div class="stat-card">
            <div class="stat-icon">❤️</div>
            <div class="stat-content">
                <h3>Mes Favoris</h3>
                <p class="stat-number">{{ $nbFavoris }}</p>
                <a href="{{ route('favoris') }}" class="stat-link">Voir mes favoris →</a>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-icon">👥</div>
            <div class="stat-content">
                <h3>Mes Amis</h3>
                <p class="stat-number">{{ $nbAmis }}</p>
                <a href="{{ route('amis') }}" class="stat-link">Gérer mes amis →</a>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-icon">🎁</div>
            <div class="stat-content">
                <h3>Partages reçus</h3>
                <p class="stat-number">{{ $nbPartages }}</p>
                <a href="{{ route('partages') }}" class="stat-link">Voir les partages →</a>
            </div>
        </div>
    </div>

    <!-- Actions rapides -->
    <section class="quick-actions">
        <h2>Actions rapides</h2>
        <div class="action-buttons">
            <a href="{{ route('films.search') }}" class="btn btn-primary btn-large">🔍 Rechercher un film</a>
            <a href="{{ route('profil.edit') }}" class="btn btn-secondary btn-large">✏️ Éditer mon profil</a>
            <a href="{{ route('amis') }}" class="btn btn-secondary btn-large">➕ Ajouter des amis</a>
        </div>
    </section>
</div>
@endsection
