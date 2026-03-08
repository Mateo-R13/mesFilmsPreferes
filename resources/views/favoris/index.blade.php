@extends('templates.app')

@section('title', 'Mes favoris')

@section('content')
<div class="section-header">
    <h1 class="section-title">⭐ Mes favoris</h1>
    <a class="btn btn--primary" href="{{ route('films.search') }}">+ Ajouter un film</a>
</div>

@if($favoris->isEmpty())
    <div class="empty">
        Tu n'as pas encore de film en favori.<br>
        <a href="{{ route('films.search') }}" style="color:var(--gold)">Rechercher un film</a>
    </div>
@else
    <div class="films-grid">
        @foreach($favoris as $favori)
            <div class="film-card {{ $favori->affiche ? '' : 'film-card--no-poster' }}">

                @if($favori->affiche)
                    <div class="film-card__poster"
                         style="background-image:url('https://image.tmdb.org/t/p/w500{{ $favori->affiche }}')"
                         aria-hidden="true"></div>
                @endif

                <div class="film-card__body">
                    <h3 class="film-card__title">{{ $favori->titre }}</h3>
                    <p class="film-card__meta">
                        {{ $favori->annee ?? '' }}
                        @if($favori->note_tmdb)
                            &nbsp;• ⭐ {{ number_format($favori->note_tmdb,1) }}/10
                        @endif
                    </p>

                    {{-- Avis --}}
                    <div style="background:rgba(0,0,0,.4); border-radius:12px; padding:12px; margin:4px 0">
                        @if($favori->avis)
                            <div class="stars" style="margin-bottom:6px">
                                @for($i=1;$i<=5;$i++)
                                    <span class="star {{ $i <= $favori->avis->note ? 'active' : '' }}">★</span>
                                @endfor
                            </div>
                            @if($favori->avis->commentaire)
                                <p class="small" style="margin:0">"{{ $favori->avis->commentaire }}"</p>
                            @endif
                            <form method="POST" action="{{ route('avis.destroy', $favori->avis->id) }}" style="margin-top:8px">
                                @csrf
                                <button class="btn btn--ghost btn--sm" style="color:var(--muted)" type="submit">Supprimer l'avis</button>
                            </form>
                        @else
                            <form method="POST" action="{{ route('avis.add', $favori->id) }}" class="form">
                                @csrf
                                <div class="stars" id="stars-{{ $favori->id }}" style="margin-bottom:8px">
                                    @for($i=1;$i<=5;$i++)
                                        <span class="star" data-val="{{ $i }}" onclick="setNote({{ $favori->id }},{{ $i }})">★</span>
                                    @endfor
                                </div>
                                <input type="hidden" name="note" id="note-{{ $favori->id }}" value="0">
                                <textarea class="textarea" name="commentaire" placeholder="Ton avis (optionnel)..." style="min-height:70px"></textarea>
                                <button class="btn btn--gold btn--sm" type="submit">Enregistrer l'avis</button>
                            </form>
                        @endif
                    </div>

                    <div class="film-card__actions">
                        <form method="POST" action="{{ route('favoris.destroy', $favori->id) }}">
                            @csrf
                            <button class="btn btn--danger btn--sm" type="submit"
                                    onclick="return confirm('Retirer ce film des favoris ?')">Retirer</button>
                        </form>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
@endif

<script>
function setNote(id,val){
  document.getElementById('note-'+id).value=val;
  document.querySelectorAll('#stars-'+id+' .star').forEach((s,i)=>{
    s.classList.toggle('active', i<val);
  });
}
</script>
@endsection
