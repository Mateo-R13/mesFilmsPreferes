@extends('templates.app')
@section('title', 'Mes invitations')
@section('content')
<div style="max-width:700px;margin:0 auto">

    <div class="section-header">
        <h1 class="section-title">✉️ Mes invitations</h1>
        <a href="{{ route('profil') }}" class="btn">← Retour au profil</a>
    </div>

    @if(session('success'))
        <div class="alert alert--ok" style="margin-bottom:16px">{{ session('success') }}</div>
    @endif

    {{-- Deux boutons d'action --}}
    <div style="display:flex;gap:12px;margin-bottom:24px;flex-wrap:wrap">
        <button class="btn btn--primary" onclick="document.getElementById('modal-inviter').style.display='flex'">➕ Inviter un utilisateur</button>
        <button class="btn" onclick="document.getElementById('modal-liste').style.display='flex'">📋 Mes invitations envoyées ({{ $invitations->count() }})</button>
    </div>

    {{-- Aperçu rapide des invitations --}}
    @if($invitations->isNotEmpty())
        <div class="card">
            <h2 style="font-size:16px;margin:0 0 14px;font-weight:700">Dernières invitations</h2>
            <div style="display:flex;flex-direction:column;gap:10px">
                @foreach($invitations->take(5) as $inv)
                <div style="display:flex;align-items:center;justify-content:space-between;padding:10px 12px;background:rgba(255,255,255,.04);border:1px solid var(--border);border-radius:12px">
                    <div>
                        <div style="font-weight:600">{{ $inv->prenom }} {{ $inv->nom }}</div>
                        <div class="small">{{ $inv->email }}</div>
                    </div>
                    <div>
                        @if($inv->accepte)
                            <span style="color:var(--ok);font-size:13px;font-weight:600">✅ Acceptée</span>
                        @else
                            <span style="color:var(--muted);font-size:13px">⏳ En attente</span>
                        @endif
                    </div>
                </div>
                @endforeach
            </div>
            @if($invitations->count() > 5)
                <div style="text-align:center;margin-top:12px">
                    <button class="btn btn--sm" onclick="document.getElementById('modal-liste').style.display='flex'">Voir toutes ({{ $invitations->count() }})</button>
                </div>
            @endif
        </div>
    @else
        <div class="empty" style="padding:40px 0">
            <div style="font-size:40px;margin-bottom:12px">✉️</div>
            <div style="font-weight:700;margin-bottom:6px">Aucune invitation envoyée</div>
            <div class="small">Invite tes proches à rejoindre la communauté !</div>
        </div>
    @endif

</div>

{{-- MODALE : Inviter un utilisateur --}}
<div id="modal-inviter" style="display:none;position:fixed;inset:0;z-index:100;align-items:center;justify-content:center;background:rgba(0,0,0,.6);backdrop-filter:blur(4px)">
    <div class="card" style="width:100%;max-width:460px;margin:20px;position:relative">
        <button onclick="document.getElementById('modal-inviter').style.display='none'" style="position:absolute;top:14px;right:14px;background:none;border:none;color:var(--muted);font-size:20px;cursor:pointer;line-height:1">✕</button>
        <h2 style="font-size:18px;font-weight:700;margin:0 0 18px">➕ Inviter un utilisateur</h2>

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
                <textarea class="input" id="message" name="message" maxlength="500" placeholder="Rejoins-moi sur MesFilmsPréférés, c'est top pour partager nos films !">{{ old('message') }}</textarea>
            </div>
            <div style="display:flex;gap:10px;justify-content:flex-end;margin-top:4px">
                <button type="button" class="btn" onclick="document.getElementById('modal-inviter').style.display='none'">Annuler</button>
                <button type="submit" class="btn btn--primary">Envoyer l'invitation ✉️</button>
            </div>
        </form>
    </div>
</div>

{{-- MODALE : Liste des invitations --}}
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

{{-- Ré-ouvrir la modale si erreurs de validation --}}
@if($errors->any())
<script>document.getElementById('modal-inviter').style.display='flex';</script>
@endif
@endsection
