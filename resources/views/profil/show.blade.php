@extends('templates.app')
@section('title', 'Mon profil')
@section('content')
<div style="max-width:700px;margin:0 auto">
    <div class="section-header">
        <h1 class="section-title">👤 Mon profil</h1>
        <a class="btn" href="{{ route('profil.edit') }}">✏️ Modifier</a>
    </div>

    <div class="card" style="margin-bottom:20px">
        <div style="display:grid;grid-template-columns:1fr 1fr;gap:16px">
            <div>
                <div class="small">Prénom</div>
                <div style="font-weight:700;font-size:18px">{{ $user->firstname }}</div>
            </div>
            <div>
                <div class="small">Nom</div>
                <div style="font-weight:700;font-size:18px">{{ $user->lastname }}</div>
            </div>
            <div>
                <div class="small">Nom d'utilisateur</div>
                <div style="font-weight:700">@{{ $user->username }}</div>
            </div>
            <div>
                <div class="small">Email</div>
                <div style="font-weight:700">{{ $user->email }}</div>
            </div>
            <div>
                <div class="small">Membre depuis</div>
                <div style="font-weight:700">{{ $user->created_at->translatedFormat('d F Y') }}</div>
            </div>
        </div>
    </div>

    {{-- Statistiques --}}
    <div style="display:grid;grid-template-columns:repeat(4,1fr);gap:12px;margin-bottom:20px">
        <div class="card" style="text-align:center">
            <div style="font-size:32px;font-weight:900;color:var(--gold)">{{ $stats['favoris'] }}</div>
            <div class="small">Favoris</div>
        </div>
        <div class="card" style="text-align:center">
            <div style="font-size:32px;font-weight:900;color:var(--primary)">{{ $stats['avis'] }}</div>
            <div class="small">Avis donnés</div>
        </div>
        <div class="card" style="text-align:center">
            <div style="font-size:32px;font-weight:900;color:#23c483">{{ $stats['amis'] }}</div>
            <div class="small">Amis</div>
        </div>
        <div class="card" style="text-align:center">
            <div style="font-size:32px;font-weight:900;color:#a78bfa">{{ $stats['partages'] }}</div>
            <div class="small">Partages</div>
        </div>
    </div>

    {{-- Derniers favoris --}}
    @if($derniersFavoris->isNotEmpty())
        <h2 style="font-size:17px;margin:0 0 12px">Derniers ajouts</h2>
        <div style="display:flex;flex-wrap:wrap;gap:10px">
            @foreach($derniersFavoris as $f)
                <a href="{{ route('films.show', $f->tmdb_id) }}" style="text-decoration:none">
                    @if($f->affiche)
                        <img src="https://image.tmdb.org/t/p/w92{{ $f->affiche }}" style="width:56px;border-radius:8px;border:2px solid var(--border);transition:.15s" alt="{{ $f->titre }}">
                    @else
                        <div class="badge" style="padding:10px">{{ $f->titre }}</div>
                    @endif
                </a>
            @endforeach
        </div>
    @endif
</div>
@endsection
