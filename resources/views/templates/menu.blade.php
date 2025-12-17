<nav class="navbar">
    <div class="navbar-container">
        <!-- Logo/Titre -->
        <div class="navbar-brand">
            <a href="{{ route('home') }}" class="brand-link">
                🎬 Mes Films Préférés
            </a>
        </div>

        <!-- Menu principal -->
        <ul class="navbar-menu">
            <li><a href="{{ route('home') }}" class="nav-link">Accueil</a></li>

            <!-- Liens pour les utilisateurs connectés -->
            @auth
                <li><a href="{{ route('films.search') }}" class="nav-link">🔍 Rechercher un film</a></li>
                <li><a href="{{ route('favoris') }}" class="nav-link">❤️ Mes Favoris</a></li>
                <li><a href="{{ route('amis') }}" class="nav-link">👥 Mes Amis</a></li>
                <li><a href="{{ route('partages') }}" class="nav-link">🎁 Mes Partages</a></li>
                <li><a href="{{ route('profil') }}" class="nav-link">👤 Mon Profil</a></li>
            @endauth
        </ul>

        <!-- Section authentification -->
        <div class="navbar-auth">
            @auth
                <!-- Utilisateur connecté -->
                <div class="user-section">
                    <span class="username">👋 {{ Auth::user()->firstname }}</span>
                    <form method="POST" action="{{ route('logout') }}" class="logout-form">
                        @csrf
                        <button type="submit" class="btn btn-logout">Déconnexion</button>
                    </form>
                </div>
            @endguest

            @guest
                <!-- Utilisateur non connecté -->
                <div class="auth-links">
                    <a href="{{ route('login') }}" class="btn btn-login">Connexion</a>
                    <a href="{{ route('register') }}" class="btn btn-register">Inscription</a>
                </div>
            @endguest
        </div>
    </div>
</nav>
