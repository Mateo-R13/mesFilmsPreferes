@extends('templates.app', ['title' => 'Créer un compte'])

@section('content')
<div class="flex justify-center items-start py-10">
    <div class="w-full max-w-md">
        {{-- Titre --}}
        <div class="text-center mb-8">
            <div class="inline-flex items-center justify-center w-16 h-16 rounded-2xl mb-4" style="background:rgba(246,196,83,.12); border:1px solid rgba(246,196,83,.3)">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="#f6c453" class="w-8 h-8">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.499-1.632Z" />
                </svg>
            </div>
            <h1 class="text-3xl font-bold text-white">Rejoins la cinémathèque</h1>
            <p class="mt-1 text-sm" style="color:rgba(168,172,192,1)">Crée ton compte pour partager tes films</p>
        </div>

        {{-- Formulaire --}}
        <div class="rounded-2xl border p-8" style="background:rgba(255,255,255,.05); border-color:rgba(255,255,255,.1)">
            <form method="POST" action="{{ route('register.store') }}" class="space-y-4">
                @csrf

                {{-- Ligne prénom / nom --}}
                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label for="firstname" class="block text-sm mb-1.5" style="color:rgba(168,172,192,1)">Prénom</label>
                        <input type="text" name="firstname" id="firstname" value="{{ old('firstname') }}" placeholder="Jean"
                            class="w-full rounded-xl px-4 py-3 text-sm outline-none"
                            style="background:rgba(255,255,255,.06); border:1px solid rgba(255,255,255,.12); color:#e8e8f0;"
                            onfocus="this.style.borderColor='rgba(246,196,83,.55)'"
                            onblur="this.style.borderColor='rgba(255,255,255,.12)'"
                        />
                        @error('firstname')<p class="mt-1 text-xs" style="color:#ff8080">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <label for="lastname" class="block text-sm mb-1.5" style="color:rgba(168,172,192,1)">Nom</label>
                        <input type="text" name="lastname" id="lastname" value="{{ old('lastname') }}" placeholder="Dupont"
                            class="w-full rounded-xl px-4 py-3 text-sm outline-none"
                            style="background:rgba(255,255,255,.06); border:1px solid rgba(255,255,255,.12); color:#e8e8f0;"
                            onfocus="this.style.borderColor='rgba(246,196,83,.55)'"
                            onblur="this.style.borderColor='rgba(255,255,255,.12)'"
                        />
                        @error('lastname')<p class="mt-1 text-xs" style="color:#ff8080">{{ $message }}</p>@enderror
                    </div>
                </div>

                {{-- Pseudo --}}
                <div>
                    <label for="username" class="block text-sm mb-1.5" style="color:rgba(168,172,192,1)">Pseudo</label>
                    <input type="text" name="username" id="username" value="{{ old('username') }}" placeholder="cinephile42"
                        class="w-full rounded-xl px-4 py-3 text-sm outline-none"
                        style="background:rgba(255,255,255,.06); border:1px solid rgba(255,255,255,.12); color:#e8e8f0;"
                        onfocus="this.style.borderColor='rgba(246,196,83,.55)'"
                        onblur="this.style.borderColor='rgba(255,255,255,.12)'"
                    />
                    @error('username')<p class="mt-1 text-xs" style="color:#ff8080">{{ $message }}</p>@enderror
                </div>

                {{-- Email --}}
                <div>
                    <label for="email" class="block text-sm mb-1.5" style="color:rgba(168,172,192,1)">Adresse e-mail</label>
                    <input type="email" name="email" id="email" value="{{ old('email') }}" placeholder="exemple@mail.com"
                        class="w-full rounded-xl px-4 py-3 text-sm outline-none"
                        style="background:rgba(255,255,255,.06); border:1px solid rgba(255,255,255,.12); color:#e8e8f0;"
                        onfocus="this.style.borderColor='rgba(246,196,83,.55)'"
                        onblur="this.style.borderColor='rgba(255,255,255,.12)'"
                    />
                    @error('email')<p class="mt-1 text-xs" style="color:#ff8080">{{ $message }}</p>@enderror
                </div>

                {{-- Mot de passe --}}
                <div>
                    <label for="password" class="block text-sm mb-1.5" style="color:rgba(168,172,192,1)">Mot de passe <span style="color:rgba(168,172,192,.6)">(min. 8 caractères)</span></label>
                    <input type="password" name="password" id="password" placeholder="••••••••"
                        class="w-full rounded-xl px-4 py-3 text-sm outline-none"
                        style="background:rgba(255,255,255,.06); border:1px solid rgba(255,255,255,.12); color:#e8e8f0;"
                        onfocus="this.style.borderColor='rgba(246,196,83,.55)'"
                        onblur="this.style.borderColor='rgba(255,255,255,.12)'"
                    />
                    @error('password')<p class="mt-1 text-xs" style="color:#ff8080">{{ $message }}</p>@enderror
                </div>

                {{-- Confirmation --}}
                <div>
                    <label for="password_confirmation" class="block text-sm mb-1.5" style="color:rgba(168,172,192,1)">Confirmer le mot de passe</label>
                    <input type="password" name="password_confirmation" id="password_confirmation" placeholder="••••••••"
                        class="w-full rounded-xl px-4 py-3 text-sm outline-none"
                        style="background:rgba(255,255,255,.06); border:1px solid rgba(255,255,255,.12); color:#e8e8f0;"
                        onfocus="this.style.borderColor='rgba(246,196,83,.55)'"
                        onblur="this.style.borderColor='rgba(255,255,255,.12)'"
                    />
                </div>

                {{-- Bouton --}}
                <button type="submit" class="w-full py-3 rounded-xl font-semibold text-sm transition-all hover:opacity-90 active:scale-[.98] cursor-pointer mt-2" style="background:linear-gradient(135deg,#e50914,#ff2a6d); color:white">
                    Créer mon compte
                </button>
            </form>
        </div>

        <p class="text-center mt-4 text-sm" style="color:rgba(168,172,192,1)">
            Déjà un compte ?
            <a href="{{ route('login') }}" class="font-semibold" style="color:#f6c453">Se connecter</a>
        </p>
    </div>
</div>
@endsection
