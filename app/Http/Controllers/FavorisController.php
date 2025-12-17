<?php

namespace App\Http\Controllers;

use App\Models\Favori;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FavorisController extends Controller
{
    /**
     * Affiche tous les favoris de l'utilisateur connecté
     * 
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $user = Auth::user();
        $favoris = $user->favoris()->with('avis')->get();

        return view('favoris.index', [
            'favoris' => $favoris,
        ]);
    }

    /**
     * Ajoute un film aux favoris
     * 
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        // Validation
        $validated = $request->validate([
            'favori_id' => 'required|unique:favoris,favori_id,NULL,id,user_id,' . Auth::id(),
            'film_title' => 'required|string|max:255',
            'film_year' => 'nullable|string',
            'film_overview' => 'nullable|string',
            'film_poster_path' => 'nullable|string',
        ], [
            'favori_id.unique' => 'Ce film est déjà dans vos favoris.',
        ]);

        // Création du favori
        Favori::create([
            'favori_id' => $validated['favori_id'],
            'film_title' => $validated['film_title'],
            'film_year' => $validated['film_year'],
            'film_overview' => $validated['film_overview'],
            'film_poster_path' => $validated['film_poster_path'],
            'user_id' => Auth::id(),
        ]);

        return redirect()->back()->with('success', 'Film ajouté aux favoris !');
    }

    /**
     * Supprime un favori
     * 
     * @param Favori $favori
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Favori $favori)
    {
        // Vérifier que l'utilisateur est le propriétaire du favori
        if ($favori->user_id !== Auth::id()) {
            return redirect()->back()->with('error', 'Vous n\'avez pas la permission de supprimer ce favori.');
        }

        // Supprimer le favori (les avis seront supprimés par cascade)
        $favori->delete();

        return redirect()->back()->with('success', 'Film supprimé des favoris.');
    }
}
