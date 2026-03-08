@extends('templates.app')
@section('title', $user->username . ' — Profil')
@section('content')
<div style="max-width:900px;margin:0 auto">

    {{-- En-tête --}}
    <div class="section-header" style="margin-bottom:24px">
        <div style="display:flex;align-items:center;gap:16px">
            <a class="btn btn--ghost btn--sm" href="{{ route('amis') }}">← Mes amis</a>
            <div>
                <h1 style="margin:0;font-size:clamp(20px,3vw,30px);font-weight:900">
                    👤 {{ $user->firstname }} {{ $user->lastname }}
                </h1>
                <p class="small" style="margin:4px 0 0">{{ $user->username }}</p>
            </div>
        </div>
        @if($estAmi)
            <form method="POST" action="{{ route('amis.remove', $user->id) }}">
                @csrf
                <button class="btn btn--danger btn--sm" type="submit">Retirer des amis</button>
            </form>
        @endif
    </div>

    {{-- Statistiques --}}
    <div style="display:grid;grid-template-columns:repeat({{ $stats['note_moyenne'] ? '4' : '3' }},1fr);gap:12px;margin-bottom:28px">
        <div class="stat-card">
            <div class="stat-card__num" style="color:var(--gold)">{{ $stats['favoris'] }}</div>
            <div class="stat-card__label">Favoris</div>
        </div>
        <div class="stat-card">
            <div class="stat-card__num" style="color:var(--primary)">{{ $stats['avis'] }}</div>
            <div class="stat-card__label">Avis donnés</div>
        </div>
        @if($stats['note_moyenne'])
            <div class="stat-card">
                <div class="stat-card__num" style="color:var(--gold);font-size:20px">
                    @for($i=1;$i<=5;$i++)
                        <span class="{{ $i <= round($stats['note_moyenne']) ? 'star--on' : 'star--off' }}">★</span>
                    @endfor
                    <div style="font-size:13px;margin-top:2px">{{ $stats['note_moyenne'] }}/5</div>
                </div>
                <div class="stat-card__label">Note moyenne</div>
            </div>
        @endif
        <div class="stat-card">
            <div class="stat-card__num" style="color:#23c483">{{ $stats['amis'] }}</div>
            <div class="stat-card__label">Amis</div>
        </div>
    </div>

    {{-- Favoris de l'ami --}}
    <h2 style="font-size:18px;font-weight:800;margin:0 0 16px">
        ⭐ Favoris de {{ $user->firstname }}
        <span class="small" style="font-weight:400">({{ $favoris->count() }})</span>
    </h2>

    @if($favoris->isEmpty())
        <div class="empty">
            <div style="font-size:40px;margin-bottom:10px">🎬</div>
            <p>{{ $user->firstname }} n'a pas encore de favoris.</p>
        </div>
    @else
        <div class="films-grid">
            @foreach($favoris as $favori)
                <div class="film-card">
                    @if($favori->affiche)
                        <div class="film-card__poster"
                             style="background-image:url('https://image.tmdb.org/t/p/w500{{ $favori->affiche }}')"></div>
                    @endif
                    <div class="film-card__body">
                        <h3 class="film-card__title">{{ $favori->titre }}</h3>
                        <p class="film-card__meta">
                            {{ $favori->annee ?? '—' }}
                            @if($favori->note_tmdb)
                                &nbsp;• ⭐ {{ $favori->note_tmdb }}/10
                            @endif
                        </p>

                        @if($favori->synopsis)
                            <p class="film-card__synopsis">{{ Str::limit($favori->synopsis, 90) }}</p>
                        @endif

                        @if($favori->avis)
                            <div class="avis-bloc">
                                <div class="avis-stars">
                                    @for($i=1;$i<=5;$i++)
                                        <span class="{{ $i <= $favori->avis->note ? 'star--on' : 'star--off' }}">★</span>
                                    @endfor
                                    <span class="small" style="margin-left:4px">({{ $favori->avis->note }}/5)</span>
                                </div>
                                @if($favori->avis->commentaire)
                                    <p class="avis-comment">"{{ $favori->avis->commentaire }}"</p>
                                @endif
                            </div>
                        @endif

                        <div class="film-card__actions">
                            <a class="btn btn--ghost btn--sm" href="{{ route('films.show', $favori->tmdb_id) }}">Détails</a>
                            <form method="POST" action="{{ route('films.addFavori') }}">
                                @csrf
                                <input type="hidden" name="tmdb_id" value="{{ $favori->tmdb_id }}">
                                <input type="hidden" name="titre" value="{{ $favori->titre }}">
                                <input type="hidden" name="affiche" value="{{ $favori->affiche }}">
                                <input type="hidden" name="synopsis" value="{{ $favori->synopsis }}">
                                <input type="hidden" name="annee" value="{{ $favori->annee }}">
                                <input type="hidden" name="note_tmdb" value="{{ $favori->note_tmdb }}">
                                <button class="btn btn--gold btn--sm" type="submit">+ Mes favoris</button>
                            </form>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>
@endsection
