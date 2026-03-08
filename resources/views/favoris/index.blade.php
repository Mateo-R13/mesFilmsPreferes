@extends('templates.app')
@section('title', 'Mes favoris')
@section('content')
<div class="section-header">
    <h1 class="section-title">⭐ Mes favoris</h1>
    <a class="btn btn--primary" href="{{ route('films.search') }}">+ Ajouter un film</a>
</div>

@if($favoris->isEmpty())
    <div class="empty">
        <div style="font-size:48px;margin-bottom:12px">🎬</div>
        <p>Tu n'as pas encore de favoris.</p>
        <a class="btn btn--primary" href="{{ route('films.search') }}">Rechercher un film</a>
    </div>
@else
    {{-- Barre de tri --}}
    <div style="display:flex;gap:10px;flex-wrap:wrap;margin-bottom:20px;align-items:center">
        <span class="small">Trier par :</span>
        <a class="btn btn--sm {{ request('tri','recent') === 'recent' ? 'btn--primary' : '' }}" href="?tri=recent">Plus récents</a>
        <a class="btn btn--sm {{ request('tri') === 'note' ? 'btn--primary' : '' }}" href="?tri=note">Meilleure note TMDB</a>
        <a class="btn btn--sm {{ request('tri') === 'titre' ? 'btn--primary' : '' }}" href="?tri=titre">Titre A→Z</a>
        <span class="small" style="margin-left:auto">{{ $favoris->count() }} film(s)</span>
    </div>

    <div class="films-grid">
        @foreach($favoris as $favori)
            <div class="film-card">
                @if($favori->affiche)
                    <div class="film-card__poster" style="background-image:url('https://image.tmdb.org/t/p/w500{{ $favori->affiche }}')"></div>
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
                        <p class="film-card__synopsis">{{ Str::limit($favori->synopsis, 100) }}</p>
                    @endif

                    @if($favori->avis)
                        <div class="avis-bloc">
                            <div class="avis-stars">
                                @for($i=1;$i<=5;$i++)
                                    <span class="{{ $i <= $favori->avis->note ? 'star--on' : 'star--off' }}">★</span>
                                @endfor
                            </div>
                            @if($favori->avis->commentaire)
                                <p class="avis-comment">{{ $favori->avis->commentaire }}</p>
                            @endif
                            <div style="display:flex;gap:8px;margin-top:8px">
                                <button class="btn btn--sm" onclick="toggleForm('edit-{{ $favori->id }}')" type="button">✏️ Modifier</button>
                                <form method="POST" action="{{ route('avis.destroy', $favori->avis->id) }}">
                                    @csrf
                                    <button class="btn btn--danger btn--sm" type="submit">🗑</button>
                                </form>
                            </div>
                            <div id="edit-{{ $favori->id }}" style="display:none;margin-top:10px">
                                <form method="POST" action="{{ route('avis.update', $favori->avis->id) }}">
                                    @csrf
                                    <select class="input" name="note" required style="margin-bottom:8px">
                                        @for($i=1;$i<=5;$i++)
                                            <option value="{{ $i }}" {{ $favori->avis->note == $i ? 'selected' : '' }}>{{ $i }} ★</option>
                                        @endfor
                                    </select>
                                    <textarea class="input" name="commentaire" rows="2" placeholder="Commentaire...">{{ $favori->avis->commentaire }}</textarea>
                                    <button class="btn btn--primary btn--sm" type="submit" style="margin-top:6px">Enregistrer</button>
                                </form>
                            </div>
                        </div>
                    @else
                        <button class="btn btn--sm" onclick="toggleForm('avis-{{ $favori->id }}')" type="button">+ Donner un avis</button>
                        <div id="avis-{{ $favori->id }}" style="display:none;margin-top:10px">
                            <form method="POST" action="{{ route('avis.add', $favori->id) }}">
                                @csrf
                                <select class="input" name="note" required style="margin-bottom:8px">
                                    @for($i=1;$i<=5;$i++)
                                        <option value="{{ $i }}">{{ $i }} ★</option>
                                    @endfor
                                </select>
                                <textarea class="input" name="commentaire" rows="2" placeholder="Commentaire (optionnel)..."></textarea>
                                <button class="btn btn--primary btn--sm" type="submit" style="margin-top:6px">Enregistrer</button>
                            </form>
                        </div>
                    @endif

                    <div class="film-card__actions" style="margin-top:10px">
                        <a class="btn btn--ghost btn--sm" href="{{ route('films.show', $favori->tmdb_id) }}">Détails</a>
                        <form method="POST" action="{{ route('favoris.destroy', $favori->id) }}">
                            @csrf
                            <button class="btn btn--danger btn--sm" type="submit">Retirer</button>
                        </form>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
@endif

<script>
function toggleForm(id){
    const el = document.getElementById(id);
    el.style.display = el.style.display === 'none' ? 'block' : 'none';
}
</script>
@endsection
