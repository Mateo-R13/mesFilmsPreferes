<?php

namespace App\Http\Controllers;

use App\Models\Favori;
use App\Models\Partage;
use App\Models\Ami;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PartagesController extends Controller
{
    public function index()
    {
        $userId = Auth::id();

        // Films reçus (je suis le ami_id)
        $recus = Partage::with(['favori', 'expediteur'])
            ->where('ami_id', $userId)
            ->latest()
            ->get();

        // Films envoyés (je suis le user_id)
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

        $favori = Favori::where('id', $request->favori_id)
                        ->where('user_id', Auth::id())
                        ->firstOrFail();

        Partage::create([
            'user_id'  => Auth::id(),   // celui qui partage
            'ami_id'   => $request->ami_id, // celui qui reçoit
            'favori_id' => $favori->id,
            'message'   => $request->message,
        ]);

        return back()->with('success', '« ' . $favori->titre . ' » partagé avec succès !');
    }
}
