<?php

namespace App\Http\Controllers;

use App\Models\Ami;
use App\Models\Favori;
use App\Models\Partage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PartagesController extends Controller
{
    public function index()
    {
        $userId = Auth::id();

        $favoris  = Favori::where('user_id', $userId)->get();
        $amisIds  = Ami::where('user_id', $userId)->pluck('ami_id');
        $mesAmis  = \App\Models\User::whereIn('id', $amisIds)->get();

        $partagesEnvoyes = Partage::where('user_id', $userId)
                                  ->with(['favori', 'destinataire'])
                                  ->latest()
                                  ->get();

        $partagesRecus = Partage::where('destinataire_id', $userId)
                                ->with(['favori', 'expediteur'])
                                ->latest()
                                ->get();

        return view('partages.index', compact('favoris', 'mesAmis', 'partagesEnvoyes', 'partagesRecus'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'favori_id' => ['required', 'exists:favoris,id'],
            'ami_id'    => ['required', 'exists:users,id'],
        ]);

        $favori = Favori::findOrFail($request->favori_id);

        if ($favori->user_id !== Auth::id()) {
            abort(403);
        }

        Partage::firstOrCreate([
            'user_id'         => Auth::id(),
            'favori_id'       => $request->favori_id,
            'destinataire_id' => $request->ami_id,
        ]);

        return back()->with('success', 'Film partagé avec succès !');
    }
}
