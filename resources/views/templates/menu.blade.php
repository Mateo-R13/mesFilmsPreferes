<nav class="sticky top-0 z-50 backdrop-blur-md border-b" style="background:rgba(7,7,11,.85); border-color:rgba(255,255,255,.1)">
    <div class="max-w-6xl mx-auto px-6 py-3 flex items-center justify-between gap-4">

        {{-- Logo --}}
        <a href="{{ route('home') }}" class="flex items-center gap-2 font-bold text-white text-lg tracking-tight">
            <span class="inline-block w-2.5 h-2.5 rounded-full" style="background:#f6c453; box-shadow:0 0 0 5px rgba(246,196,83,.15)"></span>
            Mes Films Préférés
        </a>

        {{-- Liens nav --}}
        <ul class="flex flex-wrap items-center gap-1 list-none m-0 p-0">
            <li>
                <a href="{{ route('home') }}" class="px-3 py-2 rounded-xl text-sm transition-all duration-150 hover:bg-white/10" style="color:rgba(168,172,192,1)">
                    Accueil
                </a>
            </li>
            @auth
                <li>
                    <a href="{{ route('films.search') }}" class="px-3 py-2 rounded-xl text-sm transition-all duration-150 hover:bg-white/10" style="color:rgba(168,172,192,1)">
                        Rechercher un film
                    </a>
                </li>
                <li>
                    <a href="{{ route('favoris') }}" class="px-3 py-2 rounded-xl text-sm transition-all duration-150 hover:bg-white/10" style="color:rgba(168,172,192,1)">
                        Mes favoris
                    </a>
                </li>
                <li>
                    <a href="{{ route('amis') }}" class="px-3 py-2 rounded-xl text-sm transition-all duration-150 hover:bg-white/10" style="color:rgba(168,172,192,1)">
                        Mes amis
                    </a>
                </li>
                <li>
                    <a href="{{ route('partages') }}" class="px-3 py-2 rounded-xl text-sm transition-all duration-150 hover:bg-white/10" style="color:rgba(168,172,192,1)">
                        Mes partages
                    </a>
                </li>
                <li>
                    <a href="{{ route('profil') }}" class="px-3 py-2 rounded-xl text-sm transition-all duration-150 hover:bg-white/10" style="color:rgba(168,172,192,1)">
                        Mon profil
                    </a>
                </li>
            @endauth
        </ul>

        {{-- Utilisateur --}}
        <div class="flex items-center gap-3">
            @auth
                <span class="text-sm px-3 py-1.5 rounded-full border" style="color:rgba(168,172,192,1); border-color:rgba(255,255,255,.12); background:rgba(255,255,255,.04)">
                    {{ Auth::user()->username ?? Auth::user()->firstname }}
                </span>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="text-sm px-3 py-2 rounded-xl border cursor-pointer transition-all hover:bg-red-500/20" style="color:#ff8080; border-color:rgba(229,9,20,.3); background:rgba(229,9,20,.1)">
                        Déconnexion
                    </button>
                </form>
            @endauth

            @guest
                <a href="{{ route('register') }}" class="text-sm px-3 py-2 rounded-xl border transition-all hover:bg-white/10" style="color:rgba(168,172,192,1); border-color:rgba(255,255,255,.12)">
                    Créer un compte
                </a>
                <a href="{{ route('login') }}" class="text-sm px-4 py-2 rounded-xl font-semibold transition-all" style="background:linear-gradient(135deg,#e50914,#ff2a6d); color:white">
                    Connexion
                </a>
            @endguest
        </div>

    </div>
</nav>
