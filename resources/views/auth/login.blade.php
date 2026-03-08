@extends('templates.app', ['title' => 'Connexion'])

@section('content')
<div class="flex justify-center items-start py-10">
    <div class="w-full max-w-md">
        {{-- Titre --}}
        <div class="text-center mb-8">
            <div class="inline-flex items-center justify-center w-16 h-16 rounded-2xl mb-4" style="background:rgba(229,9,20,.15); border:1px solid rgba(229,9,20,.3)">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="#e50914" class="w-8 h-8">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M3.375 19.5h17.25m-17.25 0a1.125 1.125 0 0 1-1.125-1.125M3.375 19.5h1.5C5.496 19.5 6 18.996 6 18.375m-3.75.125A1.125 1.125 0 0 1 1.125 18V4.875C1.125 4.254 1.629 3.75 2.25 3.75h19.5c.621 0 1.125.504 1.125 1.125V18a1.125 1.125 0 0 1-1.125 1.125M6 18.375v-4.875a.75.75 0 0 1 .75-.75h10.5a.75.75 0 0 1 .75.75v4.875m0 0a1.125 1.125 0 0 0 1.125-1.125v-13.5a1.125 1.125 0 0 0-1.125-1.125H6.375a1.125 1.125 0 0 0-1.125 1.125v13.5a1.125 1.125 0 0 0 1.125 1.125" />
                </svg>
            </div>
            <h1 class="text-3xl font-bold text-white">Bon retour !</h1>
            <p class="mt-1 text-sm" style="color:rgba(168,172,192,1)">Connecte-toi pour accéder à tes films</p>
        </div>

        {{-- Formulaire --}}
        <div class="rounded-2xl border p-8" style="background:rgba(255,255,255,.05); border-color:rgba(255,255,255,.1)">
            <form method="POST" action="{{ route('login.store') }}" class="space-y-5">
                @csrf

                {{-- Email --}}
                <div>
                    <label for="email" class="block text-sm mb-1.5" style="color:rgba(168,172,192,1)">Adresse e-mail</label>
                    <input
                        type="email"
                        name="email"
                        id="email"
                        value="{{ old('email') }}"
                        autocomplete="email"
                        placeholder="exemple@mail.com"
                        class="w-full rounded-xl px-4 py-3 text-sm outline-none transition-all"
                        style="background:rgba(255,255,255,.06); border:1px solid rgba(255,255,255,.12); color:#e8e8f0;"
                        onfocus="this.style.borderColor='rgba(246,196,83,.55)'; this.style.boxShadow='0 0 0 3px rgba(246,196,83,.12)'"
                        onblur="this.style.borderColor='rgba(255,255,255,.12)'; this.style.boxShadow='none'"
                    />
                    @error('email')
                        <p class="mt-1 text-xs" style="color:#ff8080">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Mot de passe --}}
                <div>
                    <label for="password" class="block text-sm mb-1.5" style="color:rgba(168,172,192,1)">Mot de passe</label>
                    <input
                        type="password"
                        name="password"
                        id="password"
                        autocomplete="current-password"
                        placeholder="••••••••"
                        class="w-full rounded-xl px-4 py-3 text-sm outline-none transition-all"
                        style="background:rgba(255,255,255,.06); border:1px solid rgba(255,255,255,.12); color:#e8e8f0;"
                        onfocus="this.style.borderColor='rgba(246,196,83,.55)'; this.style.boxShadow='0 0 0 3px rgba(246,196,83,.12)'"
                        onblur="this.style.borderColor='rgba(255,255,255,.12)'; this.style.boxShadow='none'"
                    />
                    @error('password')
                        <p class="mt-1 text-xs" style="color:#ff8080">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Bouton --}}
                <button type="submit" class="w-full py-3 rounded-xl font-semibold text-white text-sm transition-all hover:opacity-90 active:scale-[.98] cursor-pointer" style="background:linear-gradient(135deg,#e50914,#ff2a6d)">
                    Se connecter
                </button>
            </form>
        </div>

        <p class="text-center mt-4 text-sm" style="color:rgba(168,172,192,1)">
            Pas encore de compte ?
            <a href="{{ route('register') }}" class="font-semibold" style="color:#f6c453">Créer un compte</a>
        </p>
    </div>
</div>
@endsection
