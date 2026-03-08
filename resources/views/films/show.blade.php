@extends('templates.app')

@section('title', $film['title'])

@section('content')
<div style="margin-bottom:18px">
    <a class="btn btn--ghost" href="{{ url()->previous() }}">← Retour</a>
</div>

<div style="display:grid; grid-template-columns:280px 1fr; gap:28px; align-items:start">

    {{-- Affiche --}}
    <div>
        @if($film['poster_path'])
            <img src="https://image.tmdb.org/t/p/w500{{ $film['poster_path'] }}"
                 alt="Affiche {{ $film['title'] }}"
                 style="width:100%; border-radius:var(--radius2); box-shadow:var(--shadow)">
        @else
            <div class="card" style="min-height:380px; display:flex; align-items:center; justify-content:center">
                <span class="muted">Pas d'affiche</span>
            </div>
        @endif
    </div>

    {{-- Infos --}}
    <div style="display:grid; gap:18px">

        <div class="card">
            <h1 style="margin:0 0 6px; font-size:clamp(22px,3vw,36px); font-weight:900; letter-spacing:-.6px">{{ $film['title'] }}</h1>

            @if(isset($film['tagline']) && $film['tagline'])
                <p style="color:var(--gold); margin:0 0 12px; font-style:italic">"{{ $film['tagline'] }}"</p>
            @endif

            <div style="display:flex; flex-wrap:wrap; gap:10px; margin-bottom:16px">
                @if(isset($film['release_date']) && $film['release_date'])
                    <span class="badge">📅 {{ substr($film['release_date'],0,4) }}</span>
                @endif
                @if(isset($film['runtime']) && $film['runtime'])
                    <span class="badge">⏱ {{ $film['runtime'] }} min</span>
                @endif
                @if(isset($film['vote_average']) && $film['vote_average'] > 0)
                    <span class="badge" style="color:var(--gold); border-color:rgba(246,196,83,.4)">⭐ {{ number_format($film['vote_average'],1) }}/10 ({{ number_format($film['vote_count']) }} votes)</span>
                @endif
                @if(isset($film['original_language']))
                    <span class="badge">🌍 {{ strtoupper($film['original_language']) }}</span>
                @endif
            </div>

            @if(isset($film['genres']) && count($film['genres']) > 0)
                <div style="display:flex; flex-wrap:wrap; gap:8px; margin-bottom:16px">
                    @foreach($film['genres'] as $genre)
                        <span class="badge" style="border-color:rgba(229,9,20,.4); color:#ff9999">{{ $genre['name'] }}</span>
                    @endforeach
                </div>
            @endif

            @if(isset($film['overview']) && $film['overview'])
                <p style="color:var(--muted); line-height:1.7; margin:0">{{ $film['overview'] }}</p>
            @endif
        </div>

        {{-- Casting --}}
        @if(isset($film['credits']['cast']) && count($film['credits']['cast']) > 0)
            <div class="card">
                <p class="small" style="margin:0 0 14px; font-weight:700; color:var(--gold)">Casting principal</p>
                <div style="display:flex; flex-wrap:wrap; gap:10px">
                    @foreach(array_slice($film['credits']['cast'], 0, 8) as $acteur)
                        <div style="text-align:center; width:80px">
                            @if($acteur['profile_path'])
                                <img src="https://image.tmdb.org/t/p/w185{{ $acteur['profile_path'] }}"
                                     style="width:60px; height:60px; border-radius:999px; object-fit:cover; border:2px solid var(--border)"
                                     alt="{{ $acteur['name'] }}">
                            @else
                                <div style="width:60px; height:60px; border-radius:999px; background:rgba(255,255,255,.08); border:2px solid var(--border); margin:0 auto; display:flex; align-items:center; justify-content:center; font-size:20px">👤</div>
                            @endif
                            <div class="small" style="margin-top:6px; font-size:11px; line-height:1.3">{{ $acteur['name'] }}</div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif

        {{-- Actions --}}
        <div class="card">
            @if($dejaEnFavori)
                <div class="alert alert--ok">✅ Ce film est déjà dans tes favoris !</div>
                <div style="margin-top:12px; display:flex; gap:10px">
                    <a class="btn btn--primary" href="{{ route('favoris') }}">Voir mes favoris</a>
                </div>
            @else
                <form method="POST" action="{{ route('films.addFavori') }}">
                    @csrf
                    <input type="hidden" name="tmdb_id" value="{{ $film['id'] }}">
                    <input type="hidden" name="titre" value="{{ $film['title'] }}">
                    <input type="hidden" name="affiche" value="{{ $film['poster_path'] ?? '' }}">
                    <input type="hidden" name="annee" value="{{ isset($film['release_date']) ? substr($film['release_date'],0,4) : '' }}">
                    <input type="hidden" name="note_tmdb" value="{{ $film['vote_average'] ?? 0 }}">
                    <button class="btn btn--gold" type="submit" style="font-size:16px; padding:14px 24px">⭐ Ajouter à mes favoris</button>
                </form>
            @endif
        </div>

    </div>
</div>
@endsection
