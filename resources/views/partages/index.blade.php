@extends('templates.app')

@section('title', 'Mes partages')

@section('content')
<div class="section-header">
    <h1 class="section-title">📤 Mes partages</h1>
</div>

{{-- Partager un favori --}}
@if($favoris->isNotEmpty() && $mesAmis->isNotEmpty())
    <div class="card" style="margin-bottom:28px">
        <p class="small" style="margin:0 0 14px; font-weight:700; color:var(--gold)">Partager un de mes favoris</p>
        <form method="POST" action="{{ route('partages.add') }}" class="form">
            @csrf
            <div style="display:grid; grid-template-columns:1fr 1fr auto; gap:10px; align-items:end">
                <div class="field">
                    <label class="label">Film à partager</label>
                    <select class="input" name="favori_id" required>
                        <option value="">-- Choisir un film --</option>
                        @foreach($favoris as $favori)
                            <option value="{{ $favori->id }}">{{ $favori->titre }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="field">
                    <label class="label">Ami destinataire</label>
                    <select class="input" name="ami_id" required>
                        <option value="">-- Choisir un ami --</option>
                        @foreach($mesAmis as $ami)
                            <option value="{{ $ami->id }}">{{ $ami->username ?? $ami->firstname }}</option>
                        @endforeach
                    </select>
                </div>
                <button class="btn btn--primary" type="submit" style="height:48px">Partager</button>
            </div>
        </form>
    </div>
@else
    <div class="alert" style="margin-bottom:20px">
        @if($favoris->isEmpty())
            Tu dois d'abord <a href="{{ route('films.search') }}" style="color:var(--gold)">ajouter des favoris</a> pour pouvoir partager.
        @elseif($mesAmis->isEmpty())
            Tu dois d'abord <a href="{{ route('amis') }}" style="color:var(--gold)">ajouter des amis</a> pour pouvoir partager.
        @endif
    </div>
@endif

{{-- Films que j'ai partagés --}}
<h2 class="small" style="margin:0 0 12px; font-weight:700; font-size:15px; color:var(--gold)">Films partagés par moi</h2>
@if($partagesEnvoyes->isEmpty())
    <div class="empty" style="padding:20px">Tu n'as encore rien partagé.</div>
@else
    <div class="films-grid" style="margin-bottom:32px">
        @foreach($partagesEnvoyes as $partage)
            <div class="card card--flat" style="display:flex; gap:14px; align-items:flex-start">
                @if($partage->favori->affiche)
                    <img src="https://image.tmdb.org/t/p/w92{{ $partage->favori->affiche }}"
                         style="width:60px; border-radius:10px; flex-shrink:0" alt="">
                @endif
                <div>
                    <div style="font-weight:700">{{ $partage->favori->titre }}</div>
                    <div class="small">Partagé à <strong>{{ $partage->destinataire->username ?? $partage->destinataire->firstname }}</strong></div>
                    <div class="small">{{ $partage->created_at->diffForHumans() }}</div>
                </div>
            </div>
        @endforeach
    </div>
@endif

{{-- Films partagés avec moi --}}
<h2 class="small" style="margin:0 0 12px; font-weight:700; font-size:15px; color:var(--gold)">📥 Films partagés avec moi</h2>
@if($partagesRecus->isEmpty())
    <div class="empty" style="padding:20px">Aucun film partagé avec toi pour le moment.</div>
@else
    <div class="films-grid">
        @foreach($partagesRecus as $partage)
            <div class="card card--flat" style="display:flex; gap:14px; align-items:flex-start">
                @if($partage->favori->affiche)
                    <img src="https://image.tmdb.org/t/p/w92{{ $partage->favori->affiche }}"
                         style="width:60px; border-radius:10px; flex-shrink:0" alt="">
                @endif
                <div>
                    <div style="font-weight:700">{{ $partage->favori->titre }}</div>
                    <div class="small">Partagé par <strong>{{ $partage->expediteur->username ?? $partage->expediteur->firstname }}</strong></div>
                    <div class="small">{{ $partage->created_at->diffForHumans() }}</div>
                </div>
            </div>
        @endforeach
    </div>
@endif
@endsection
