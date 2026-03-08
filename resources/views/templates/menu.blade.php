<nav class="nav">
    <div class="nav__inner">
        <a class="brand" href="{{ route('home') }}">
            <span class="brand__dot" aria-hidden="true"></span>
            <span>Mes Films Préférés</span>
        </a>

        <ul class="nav__list">
            <li><a class="nav__link" href="{{ route('home') }}">Accueil</a></li>
            @auth
                <li><a class="nav__link" href="{{ route('films.search') }}">Rechercher un film</a></li>
                <li><a class="nav__link" href="{{ route('favoris') }}">Mes favoris</a></li>
                <li><a class="nav__link" href="{{ route('amis') }}">Mes amis</a></li>
                <li><a class="nav__link" href="{{ route('partages') }}">Mes partages</a></li>
                <li><a class="nav__link" href="{{ route('profil') }}">Mon profil</a></li>
            @endauth
        </ul>

        <div class="nav__user">
            @auth
                <span class="pill">{{ Auth::user()->username ?? Auth::user()->email }}</span>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button class="btn btn--danger" type="submit">Déconnexion</button>
                </form>
            @endauth
            @guest
                <a class="btn btn--ghost" href="{{ route('register') }}">Créer un compte</a>
                <a class="btn btn--primary" href="{{ route('login') }}">Connexion</a>
            @endguest
        </div>
    </div>
</nav>
