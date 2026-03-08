@extends('templates.app')

@section('title', 'Mon profil')

@section('content')
<div class="section-header">
    <h1 class="section-title">👤 Mon profil</h1>
    <a class="btn" href="{{ route('profil.edit') }}">Modifier</a>
</div>

<div style="display:grid; grid-template-columns:1fr 1fr; gap:18px">
    <div class="card">
        <p class="small" style="margin:0 0 16px; font-weight:700; color:var(--gold)">Informations</p>
        <div style="display:grid; gap:12px">
            <div><span class="small">Prénom</span><br><strong>{{ Auth::user()->firstname }}</strong></div>
            <div><span class="small">Nom</span><br><strong>{{ Auth::user()->lastname }}</strong></div>
            <div><span class="small">Nom d'utilisateur</span><br><strong>{{ Auth::user()->username }}</strong></div>
            <div><span class="small">E-mail</span><br><strong>{{ Auth::user()->email }}</strong></div>
        </div>
    </div>

    <div class="card">
        <p class="small" style="margin:0 0 16px; font-weight:700; color:var(--gold)">Statistiques</p>
        <div style="display:grid; gap:12px">
            <div><span class="small">Films en favoris</span><br><strong>{{ $stats['nb_favoris'] }}</strong></div>
            <div><span class="small">Avis rédigés</span><br><strong>{{ $stats['nb_avis'] }}</strong></div>
            <div><span class="small">Amis</span><br><strong>{{ $stats['nb_amis'] }}</strong></div>
            <div><span class="small">Films partagés</span><br><strong>{{ $stats['nb_partages'] }}</strong></div>
        </div>
    </div>
</div>
@endsection
