<?php

namespace App\Http\Controllers;

use App\Models\Ami;
use App\Models\Favori;
use App\Models\Partage;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PartagesController extends Controller
{
    public function index()
    {
        $userId = Auth::id();

        $recus = Partage::with(['favori', 'expediteur'])
            ->where('ami_id', $userId)
            ->latest()
            ->get();

        $envoyes = Partage::with(['favori', 'destinataire'])
            ->where('user_id', $userId)
            ->latest()
            ->get();

        $favoris = Favori::where('user_id', $userId)->get();

        $mesAmisIds = Ami::where('user_id', $userId)->pluck('friend_id');
        $amis = User::whereIn('id', $mesAmisIds)->get();

        return view('partages.index', compact('recus', 'envoyes', 'favoris', 'amis'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'favori_id' => ['required', 'integer', 'exists:favoris,id'],
            'ami_id'    => ['required', 'integer', 'exists:users,id'],
            'message'   => ['nullable', 'string', 'max:500'],
        ]);

        // 🔒 Vérifier que le favori appartient bien à l'utilisateur connecté
        $favori = Favori::where('id', $request->favori_id)
                        ->where('user_id', Auth::id())
                        ->firstOrFail();

        // 🔒 Vérifier que le destinataire est bien un ami
        $estAmi = Ami::where('user_id', Auth::id())
                     ->where('friend_id', $request->ami_id)
                     ->exists();

        if (!$estAmi) {
            abort(403, 'Tu ne peux partager qu\'avec tes amis.');
        }

        // 🔒 Ne pas se partager à soi-même
        if ((int) $request->ami_id === Auth::id()) {
            return back()->with('error', 'Tu ne peux pas te partager un film à toi-même.');
        }

        Partage::create([
            'user_id'   => Auth::id(),
            'ami_id'    => $request->ami_id,
            'favori_id' => $favori->id,
            'message'   => strip_tags($request->message ?? ''),
        ]);

        return back()->with('success', '« ' . e($favori->titre) . ' » partagé avec succès !');
    }
}
