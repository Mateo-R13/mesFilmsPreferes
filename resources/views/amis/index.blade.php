@extends('templates.app')
@section('title', 'Mes amis')
@section('content')
<div class="section-header">
    <h1 class="section-title">👥 Mes amis</h1>
    <button class="btn btn--primary" onclick="document.getElementById('modal-inviter').style.display='flex'">✉️ Inviter un ami</button>
</div>

@if(session('success'))
    <div class="alert alert--ok" style="margin-bottom:16px">{{ session('success') }}</div>
@endif
@if(session('error'))
    <div class="alert alert--err" style="margin-bottom:16px">{{ session('error') }}</div>
@endif

{{-- Recherche d'utilisateurs --}}
<div class="card" style="margin-bottom:24px;max-width:500px">
    <p style="margin:0 0 10px;font-weight:700">Ajouter un ami</p>
    <form method="GET" action="{{ route('amis') }}" style="display:flex;gap:10px">
        <input class="input" type="text" name="search"
               value="{{ request('search') }}"
               placeholder="Rechercher par username ou email...">
        <button class="btn btn--primary" type="submit">Rechercher</button>
    </form>
</div>

{{-- Résultats de recherche --}}
@if(isset($usersRecherche) && $usersRecherche->isNotEmpty())
    <div class="card" style="margin-bottom:24px">
        <p class="small" style="margin:0 0 12px;font-weight:700">Résultats</p>
        @foreach($usersRecherche as $user)
            <div style="display:flex;align-items:center;justify-content:space-between;
                        padding:10px 0;border-bottom:1px solid var(--border)">
                <div>
                    <strong>{{ $user->username }}</strong>
                    <span class="small" style="margin-left:8px">{{ $user->firstname }} {{ $user->lastname }}</span>
                </div>
                @if(!$mesAmisIds->contains($user->id))
                    <form method="POST" action="{{ route('amis.add', $user->id) }}">
                        @csrf
                        <button class="btn btn--primary btn--sm" type="submit">+ Ajouter</button>
                    </form>
                @else
                    <span class="badge" style="color:var(--ok);border-color:rgba(35,196,131,.4)">✓ Déjà ami</span>
                @endif
            </div>
        @endforeach
    </div>
@elseif(request('search'))
    <div class="alert alert--err" style="margin-bottom:24px">
        Aucun utilisateur trouvé pour "{{ request('search') }}".
    </div>
@endif

{{-- Section invitations envoyées --}}
@if($invitations->isNotEmpty())
<div class="card" style="margin-bottom:24px">
    <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:12px">
        <p style="margin:0;font-weight:700">✉️ Invitations envoyées ({{ $invitations->count() }})</p>
        <button class="btn btn--sm" onclick="document.getElementById('modal-liste').style.display='flex'">Voir tout</button>
    </div>
    <div style="display:flex;flex-direction:column;gap:8px">
        @foreach($invitations->take(3) as $inv)
        <div style="display:flex;align-items:center;justify-content:space-between;padding:8px 10px;background:rgba(255,255,255,.04);border:1px solid var(--border);border-radius:10px">
            <div>
                <span style="font-weight:600">{{ $inv->prenom }} {{ $inv->nom }}</span>
                <span class="small" style="margin-left:8px">{{ $inv->email }}</span>
            </div>
            @if($inv->accepte)
                <span style="color:var(--ok);font-size:13px;font-weight:600">✅ Acceptée</span>
            @else
                <span style="color:var(--muted);font-size:13px">⏳ En attente</span>
            @endif
        </div>
        @endforeach
    </div>
</div>
@endif

{{-- Liste de mes amis --}}
@if($amis->isEmpty())
    <div class="empty">
        <div style="font-size:48px;margin-bottom:12px">👤</div>
        <p>Tu n'as pas encore d'amis. Utilise la recherche ci-dessus ou invite tes proches !</p>
    </div>
@else
    <h2 class="section-title" style="font-size:18px;margin-bottom:16px">
        Mes amis ({{ $amis->count() }})
    </h2>
    <div style="display:grid;grid-template-columns:repeat(auto-fill,minmax(260px,1fr));gap:14px">
        @foreach($amis as $ami)
            <div class="card" style="display:flex;align-items:center;justify-content:space-between;gap:12px">
                <div>
                    <div style="font-weight:700">{{ $ami->username }}</div>
                    <div class="small">{{ $ami->firstname }} {{ $ami->lastname }}</div>
                </div>
                <div style="display:flex;gap:8px">
                    <a class="btn btn--sm" href="{{ route('profil.ami', $ami->id) }}">Voir profil</a>
                    <form method="POST" action="{{ route('amis.remove', $ami->id) }}">
                        @csrf
                        <button class="btn btn--danger btn--sm" type="submit">Retirer</button>
                    </form>
                </div>
            </div>
        @endforeach
    </div>
@endif

{{-- MODALE : Inviter un utilisateur --}}
<div id="modal-inviter" style="display:none;position:fixed;inset:0;z-index:100;align-items:center;justify-content:center;background:rgba(0,0,0,.6);backdrop-filter:blur(4px)">
    <div class="card" style="width:100%;max-width:460px;margin:20px;position:relative">
        <button onclick="document.getElementById('modal-inviter').style.display='none'" style="position:absolute;top:14px;right:14px;background:none;border:none;color:var(--muted);font-size:20px;cursor:pointer;line-height:1">✕</button>
        <h2 style="font-size:18px;font-weight:700;margin:0 0 18px">✉️ Inviter un ami</h2>

        @if($errors->any())
            <div class="alert alert--err" style="margin-bottom:14px">
                @foreach($errors->all() as $err)
                    <div>{{ $err }}</div>
                @endforeach
            </div>
        @endif

        <form action="{{ route('invitations.store') }}" method="POST" class="form">
            @csrf
            <div style="display:grid;grid-template-columns:1fr 1fr;gap:12px">
                <div>
                    <label class="label" for="prenom">Prénom *</label>
                    <input class="input @error('prenom') input--error @enderror" type="text" id="prenom" name="prenom" value="{{ old('prenom') }}" required maxlength="100" placeholder="Jean">
                </div>
                <div>
                    <label class="label" for="nom">Nom *</label>
                    <input class="input @error('nom') input--error @enderror" type="text" id="nom" name="nom" value="{{ old('nom') }}" required maxlength="100" placeholder="Dupont">
                </div>
            </div>
            <div>
                <label class="label" for="email">Email *</label>
                <input class="input @error('email') input--error @enderror" type="email" id="email" name="email" value="{{ old('email') }}" required maxlength="255" placeholder="jean.dupont@exemple.fr">
            </div>
            <div>
                <label class="label" for="message">Message personnalisé <span class="muted">(optionnel)</span></label>
                <textarea class="input" id="message" name="message" maxlength="500" placeholder="Rejoins-moi sur MesFilmsPréférés !">{{ old('message') }}</textarea>
            </div>
            <div style="display:flex;gap:10px;justify-content:flex-end;margin-top:4px">
                <button type="button" class="btn" onclick="document.getElementById('modal-inviter').style.display='none'">Annuler</button>
                <button type="submit" class="btn btn--primary">Envoyer ✉️</button>
            </div>
        </form>
    </div>
</div>

{{-- MODALE : Liste complète des invitations --}}
<div id="modal-liste" style="display:none;position:fixed;inset:0;z-index:100;align-items:center;justify-content:center;background:rgba(0,0,0,.6);backdrop-filter:blur(4px)">
    <div class="card" style="width:100%;max-width:560px;margin:20px;position:relative;max-height:80vh;overflow-y:auto">
        <button onclick="document.getElementById('modal-liste').style.display='none'" style="position:absolute;top:14px;right:14px;background:none;border:none;color:var(--muted);font-size:20px;cursor:pointer;line-height:1">✕</button>
        <h2 style="font-size:18px;font-weight:700;margin:0 0 18px">📋 Toutes mes invitations</h2>
        @if($invitations->isEmpty())
            <div class="empty">Aucune invitation envoyée pour l'instant.</div>
        @else
            <div style="display:flex;flex-direction:column;gap:10px">
                @foreach($invitations as $inv)
                <div style="padding:12px 14px;background:rgba(255,255,255,.04);border:1px solid var(--border);border-radius:12px">
                    <div style="display:flex;align-items:center;justify-content:space-between;gap:10px">
                        <div>
                            <div style="font-weight:600">{{ $inv->prenom }} {{ $inv->nom }}</div>
                            <div class="small">{{ $inv->email }}</div>
                            <div class="small" style="margin-top:2px">Envoyée le {{ $inv->created_at->translatedFormat('d F Y') }}</div>
                        </div>
                        <div style="text-align:right;flex-shrink:0">
                            @if($inv->accepte)
                                <span style="color:var(--ok);font-size:13px;font-weight:600">✅ Acceptée</span>
                            @else
                                <span style="color:var(--muted);font-size:13px">⏳ En attente</span>
                            @endif
                        </div>
                    </div>
                    @if($inv->message)
                        <div style="margin-top:8px;padding:8px 10px;background:rgba(255,255,255,.04);border-radius:8px;font-size:13px;color:var(--muted);font-style:italic">"{{ $inv->message }}"</div>
                    @endif
                </div>
                @endforeach
            </div>
        @endif
    </div>
</div>

@if($errors->any())
<script>document.getElementById('modal-inviter').style.display='flex';</script>
@endif
@endsection
