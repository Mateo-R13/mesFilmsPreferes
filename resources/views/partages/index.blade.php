@extends('templates.app')
@section('title', 'Partages')
@section('content')
<div class="section-header">
    <h1 class="section-title">📤 Partages</h1>
</div>

<div style="display:grid;grid-template-columns:1fr 1fr;gap:24px">

    {{-- Films partagés avec moi --}}
    <div>
        <h2 style="font-size:18px;margin:0 0 16px">📥 Reçus ({{ $recus->count() }})</h2>
        @if($recus->isEmpty())
            <div class="empty">Personne ne t'a encore partagé de film.</div>
        @else
            @foreach($recus as $partage)
                <div class="card" style="margin-bottom:12px;display:flex;gap:14px;align-items:center">
                    @if($partage->favori && $partage->favori->affiche)
                        <img src="https://image.tmdb.org/t/p/w92{{ $partage->favori->affiche }}" style="width:50px;border-radius:8px" alt="">
                    @endif
                    <div style="flex:1">
                        <div style="font-weight:700">{{ $partage->favori->titre ?? '—' }}</div>
                        <div class="small">Partagé par <strong>{{ $partage->expediteur->username ?? '—' }}</strong></div>
                        @if($partage->message)
                            <div class="small" style="margin-top:4px;font-style:italic">"{{ $partage->message }}"</div>
                        @endif
                    </div>
                    @if($partage->favori)
                        <a class="btn btn--ghost btn--sm" href="{{ route('films.show', $partage->favori->tmdb_id) }}">Voir</a>
                    @endif
                </div>
            @endforeach
        @endif
    </div>

    {{-- Partager un de mes favoris --}}
    <div>
        <h2 style="font-size:18px;margin:0 0 16px">📤 Partager un film</h2>
        @if($favoris->isEmpty())
            <div class="empty">Ajoute des favoris pour pouvoir les partager.</div>
        @elseif($amis->isEmpty())
            <div class="empty">Ajoute des amis pour pouvoir leur partager des films.</div>
        @else
            <div class="card">
                <form method="POST" action="{{ route('partages.add') }}">
                    @csrf
                    <label class="label">Film à partager</label>
                    <select class="input" name="favori_id" required style="margin-bottom:12px">
                        <option value="">-- Choisir un film --</option>
                        @foreach($favoris as $favori)
                            <option value="{{ $favori->id }}">{{ $favori->titre }} ({{ $favori->annee }})</option>
                        @endforeach
                    </select>
                    <label class="label">Ami destinataire</label>
                    <select class="input" name="ami_id" required style="margin-bottom:12px">
                        <option value="">-- Choisir un ami --</option>
                        @foreach($amis as $ami)
                            <option value="{{ $ami->id }}">{{ $ami->username }} ({{ $ami->firstname }})</option>
                        @endforeach
                    </select>
                    <label class="label">Message (optionnel)</label>
                    <textarea class="input" name="message" rows="2" placeholder="Je pense que ce film va te plaire !"></textarea>
                    <button class="btn btn--primary" type="submit" style="margin-top:12px;width:100%">Partager 🚀</button>
                </form>
            </div>
        @endif

        {{-- Historique envoyés --}}
        @if($envoyes->isNotEmpty())
            <h2 style="font-size:16px;margin:20px 0 12px">Envoyés ({{ $envoyes->count() }})</h2>
            @foreach($envoyes as $partage)
                <div class="card" style="margin-bottom:10px;display:flex;gap:12px;align-items:center">
                    <div style="flex:1">
                        <div style="font-weight:700;font-size:14px">{{ $partage->favori->titre ?? '—' }}</div>
                        <div class="small">→ <strong>{{ $partage->destinataire->username ?? '—' }}</strong></div>
                    </div>
                </div>
            @endforeach
        @endif
    </div>
</div>
@endsection
