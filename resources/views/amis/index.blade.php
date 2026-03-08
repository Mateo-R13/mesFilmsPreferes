@extends('templates.app')
@section('title', 'Mes amis')
@section('content')
<div class="section-header">
    <h1 class="section-title">👥 Mes amis</h1>
</div>

{{-- Recherche d'utilisateurs --}}
<div class="card" style="margin-bottom:24px;max-width:500px">
    <p style="margin:0 0 10px;font-weight:700">Ajouter un ami</p>
    <form method="GET" action="{{ route('amis') }}" style="display:flex;gap:10px">
        <input class="input" type="text" name="search" value="{{ request('search') }}" placeholder="Rechercher par username ou email...">
        <button class="btn btn--primary" type="submit">Rechercher</button>
    </form>
</div>

{{-- Résultats de recherche --}}
@if(isset($usersRecherche) && $usersRecherche->isNotEmpty())
    <div class="card" style="margin-bottom:24px">
        <p class="small" style="margin:0 0 12px;font-weight:700">Résultats</p>
        @foreach($usersRecherche as $user)
            <div style="display:flex;align-items:center;justify-content:space-between;padding:10px 0;border-bottom:1px solid var(--border)">
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
    <div class="alert alert--err" style="margin-bottom:24px">Aucun utilisateur trouvé pour "{{ request('search') }}".</div>
@endif

{{-- Liste de mes amis --}}
@if($amis->isEmpty())
    <div class="empty">
        <div style="font-size:48px;margin-bottom:12px">👤</div>
        <p>Tu n'as pas encore d'amis. Utilise la recherche ci-dessus !</p>
    </div>
@else
    <h2 class="section-title" style="font-size:18px;margin-bottom:16px">Mes amis ({{ $amis->count() }})</h2>
    <div style="display:grid;grid-template-columns:repeat(auto-fill,minmax(260px,1fr));gap:14px">
        @foreach($amis as $ami)
            <div class="card" style="display:flex;align-items:center;justify-content:space-between;gap:12px">
                <div>
                    <div style="font-weight:700">{{ $ami->username }}</div>
                    <div class="small">{{ $ami->firstname }} {{ $ami->lastname }}</div>
                </div>
                <form method="POST" action="{{ route('amis.remove', $ami->id) }}">
                    @csrf
                    <button class="btn btn--danger btn--sm" type="submit">Retirer</button>
                </form>
            </div>
        @endforeach
    </div>
@endif
@endsection
