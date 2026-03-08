@extends('templates.app')

@section('title', 'Mes amis')

@section('content')
<div class="section-header">
    <h1 class="section-title">👥 Mes amis</h1>
</div>

{{-- Mes amis actuels --}}
<h2 class="small" style="margin:0 0 12px; font-weight:700; font-size:15px; color:var(--gold)">Mes amis ({{ $mesAmis->count() }})</h2>

@if($mesAmis->isEmpty())
    <div class="empty" style="padding:20px">Tu n'as pas encore d'amis ajoutés.</div>
@else
    <div class="user-list" style="margin-bottom:32px">
        @foreach($mesAmis as $ami)
            <div class="user-item">
                <div class="user-avatar">{{ strtoupper(substr($ami->username ?? $ami->firstname, 0, 1)) }}</div>
                <div class="user-info">
                    <div class="user-name">{{ $ami->username ?? $ami->firstname.' '.$ami->lastname }}</div>
                    <div class="user-email">{{ $ami->email }}</div>
                </div>
                <form method="POST" action="{{ route('amis.remove', $ami->id) }}">
                    @csrf
                    <button class="btn btn--danger btn--sm" type="submit">Retirer</button>
                </form>
            </div>
        @endforeach
    </div>
@endif

{{-- Autres utilisateurs --}}
<h2 class="small" style="margin:0 0 12px; font-weight:700; font-size:15px; color:var(--gold)">Autres utilisateurs</h2>

@if($autresUtilisateurs->isEmpty())
    <div class="empty" style="padding:20px">Aucun autre utilisateur pour le moment.</div>
@else
    <div class="user-list">
        @foreach($autresUtilisateurs as $user)
            @php
                $estAmi = $mesAmis->contains('id', $user->id);
            @endphp
            <div class="user-item">
                <div class="user-avatar">{{ strtoupper(substr($user->username ?? $user->firstname, 0, 1)) }}</div>
                <div class="user-info">
                    <div class="user-name">{{ $user->username ?? $user->firstname.' '.$user->lastname }}</div>
                    <div class="user-email">{{ $user->email }}</div>
                </div>
                @if(!$estAmi)
                    <form method="POST" action="{{ route('amis.add', $user->id) }}">
                        @csrf
                        <button class="btn btn--primary btn--sm" type="submit">+ Ami</button>
                    </form>
                @else
                    <span class="badge">✓ Ami</span>
                @endif
            </div>
        @endforeach
    </div>
@endif
@endsection
