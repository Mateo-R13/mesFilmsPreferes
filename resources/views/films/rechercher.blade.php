@extends('templates.app')

@section('title', 'Rechercher un film')

@section('content')
<div class="section-header">
    <h1 class="section-title">🔍 Rechercher un film</h1>
</div>

<form method="GET" action="{{ route('films.search') }}" class="form" style="max-width:600px; margin-bottom:32px">
    <div style="display:flex; gap:10px">
        <input class="input" type="text" name="query"
               value="{{ request('query') }}"
               placeholder="Titre du film..." autofocus required>
        <button class="btn btn--primary" type="submit">Rechercher</button>
    </div>
</form>

@if(isset($error))
    <div class="alert alert--err">{{ $error }}</div>
@endif

@if(isset($results) && count($results) > 0)
    <p class="small" style="margin-bottom:16px">{{ count($results) }} résultat(s) pour "{{ request('query') }}"</p>
    <div class="films-grid">
        @foreach($results as $film)
            <div class="film-card {{ $film['poster_path'] ? '' : 'film-card--no-poster' }}"
                 @if($film['poster_path'])
                     style="background-image:none"
                 @endif>

                @if($film['poster_path'])
                    <div class="film-card__poster"
                         style="background-image:url('https://image.tmdb.org/t/p/w500{{ $film['poster_path'] }}')"
                         aria-hidden="true"></div>
                @endif

                <div class="film-card__body">
                    <h3 class="film-card__title">{{ $film['title'] }}</h3>
                    <p class="film-card__meta">
                        {{ isset($film['release_date']) && $film['release_date'] ? substr($film['release_date'],0,4) : 'Date inconnue' }}
                        @if($film['vote_average'] > 0)
                            &nbsp;• ⭐ {{ number_format($film['vote_average'],1) }}/10
                        @endif
                    </p>

                    <div class="film-card__actions">
                        <form method="POST" action="{{ route('films.addFavori') }}">
                            @csrf
                            <input type="hidden" name="tmdb_id" value="{{ $film['id'] }}">
                            <input type="hidden" name="titre" value="{{ $film['title'] }}">
                            <input type="hidden" name="affiche" value="{{ $film['poster_path'] ?? '' }}">
                            <input type="hidden" name="annee" value="{{ isset($film['release_date']) ? substr($film['release_date'],0,4) : '' }}">
                            <input type="hidden" name="note_tmdb" value="{{ $film['vote_average'] ?? 0 }}">
                            <button class="btn btn--gold btn--sm" type="submit">+ Favoris</button>
                        </form>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
@elseif(request('query'))
    <div class="empty">Aucun film trouvé pour "{{ request('query') }}".</div>
@else
    <div class="empty">Saisis un titre pour rechercher un film dans la base TMDB.</div>
@endif
@endsection
