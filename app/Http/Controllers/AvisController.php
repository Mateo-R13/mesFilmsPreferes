<?php

namespace App\Http\Controllers;

use App\Models\Avis;
use App\Models\Favori;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AvisController extends Controller
{
    /**
     * Crée un nouvel avis sur un favori
     * 
     * @param Request $request
     * @param Favori $favori
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request, Favori $favori)
    {
        // Vérifier que le favori appartient à l'utilisateur
        if ($favori->user_id !== Auth::id()) {
            return redirect()->back()->with('error', 'Vous ne pouvez ajouter un avis que sur vos propres favoris.');
        }

        // Validation
        $validated = $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'texte' => 'required|string|min:10|max:1000',
        ], [
            'rating.required' => 'La note est obligatoire.',
            'rating.min' => 'La note doit être au minimum 1.',
            'rating.max' => 'La note doit être au maximum 5.',
            'texte.required' => 'L\'avis est obligatoire.',
            'texte.min' => 'L\'avis doit contenir au moins 10 caractères.',
            'texte.max' => 'L\'avis ne peut pas dépasser 1000 caractères.',
        ]);

        // Vérifier s'il existe déjà un avis de cet utilisateur sur ce film
        $avisExistant = Avis::where('favori_id', $favori->id)
            ->where('user_id', Auth::id())
            ->first();

        if ($avisExistant) {
            // Mise à jour de l'avis existant
            $avisExistant->update([
                'rating' => $validated['rating'],
                'texte' => $validated['texte'],
            ]);
            return redirect()->back()->with('success', 'Votre avis a été mis à jour.');
        }

        // Création d'un nouvel avis
        Avis::create([
            'favori_id' => $favori->id,
            'user_id' => Auth::id(),
            'rating' => $validated['rating'],
            'texte' => $validated['texte'],
        ]);

        return redirect()->back()->with('success', 'Votre avis a été ajouté.');
    }

    /**
     * Met à jour un avis
     * 
     * @param Request $request
     * @param Avis $avis
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, Avis $avis)
    {
        // Vérifier que l'avis appartient à l'utilisateur
        if ($avis->user_id !== Auth::id()) {
            return redirect()->back()->with('error', 'Vous ne pouvez modifier que vos propres avis.');
        }

        // Validation
        $validated = $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'texte' => 'required|string|min:10|max:1000',
        ]);

        // Mise à jour
        $avis->update($validated);

        return redirect()->back()->with('success', 'Votre avis a été mis à jour.');
    }

    /**
     * Supprime un avis
     * 
     * @param Avis $avis
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Avis $avis)
    {
        // Vérifier que l'avis appartient à l'utilisateur
        if ($avis->user_id !== Auth::id()) {
            return redirect()->back()->with('error', 'Vous ne pouvez supprimer que vos propres avis.');
        }

        $avis->delete();

        return redirect()->back()->with('success', 'Votre avis a été supprimé.');
    }
}
