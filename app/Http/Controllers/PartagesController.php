<?php

namespace App\Http\Controllers;

use App\Models\Partage;
use App\Models\Favori;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PartagesController extends Controller
{
    /**
     * Affiche les partages de l'utilisateur
     * 
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $user = Auth::user();
        
        // Les favoris de l'utilisateur qu'il peut partager
        $mesFavoris = $user->favoris()->get();
        
        // Les amis de l'utilisateur
        $mesAmis = $user->amis()->get();
        
        // Les partages qu'il a reçus de ses amis
        $partagesRecus = Partage::where('friend_id', Auth::id())
            ->with('user')
            ->get();
        
        return view('partages.index', [
            'mesFavoris' => $mesFavoris,
            'mesAmis' => $mesAmis,
            'partagesRecus' => $partagesRecus,
        ]);
    }

    /**
     * Crée un partage de favori avec un ami
     * 
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        // Validation
        $validated = $request->validate([
            'favori_id' => 'required|exists:favoris,id',
            'friend_id' => 'required|exists:users,id',
            'message' => 'nullable|string|max:500',
        ], [
            'favori_id.required' => 'Le film est obligatoire.',
            'favori_id.exists' => 'Ce film n\'existe pas.',
            'friend_id.required' => 'L\'ami est obligatoire.',
            'friend_id.exists' => 'Cet ami n\'existe pas.',
        ]);

        // Récupérer le favori
        $favori = Favori::find($validated['favori_id']);

        // Vérifier que le favori appartient à l'utilisateur connecté
        if ($favori->user_id !== Auth::id()) {
            return redirect()->back()->with('error', 'Vous ne pouvez partager que vos propres favoris.');
        }

        // Vérifier que l'ami existe et que c'est un ami
        if (!Auth::user()->amis()->where('friend_id', $validated['friend_id'])->exists()) {
            return redirect()->back()->with('error', 'Vous pouvez uniquement partager avec vos amis.');
        }

        // Vérifier qu'il n'a pas déjà partagé ce film avec cet ami
        $dejaPartage = Partage::where('user_id', Auth::id())
            ->where('favori_id', $validated['favori_id'])
            ->where('friend_id', $validated['friend_id'])
            ->exists();

        if ($dejaPartage) {
            return redirect()->back()->with('error', 'Vous avez déjà partagé ce film avec cet ami.');
        }

        // Créer le partage
        Partage::create([
            'user_id' => Auth::id(),
            'favori_id' => $validated['favori_id'],
            'film_title' => $favori->film_title,
            'film_poster_path' => $favori->film_poster_path,
            'film_tmdb_id' => $favori->favori_id,
            'friend_id' => $validated['friend_id'],
            'message' => $validated['message'],
            'avis' => $favori->avis,
        ]);

        return redirect()->back()->with('success', 'Film partagé avec succès !');
    }
}
