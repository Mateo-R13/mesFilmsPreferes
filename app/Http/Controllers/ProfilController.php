<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfilController extends Controller
{
    /**
     * Affiche le profil de l'utilisateur
     * 
     * @return \Illuminate\View\View
     */
    public function show()
    {
        $user = Auth::user();

        return view('profil.show', [
            'user' => $user,
        ]);
    }

    /**
     * Affiche le formulaire d'édition du profil
     * 
     * @return \Illuminate\View\View
     */
    public function edit()
    {
        $user = Auth::user();

        return view('profil.edit', [
            'user' => $user,
        ]);
    }

    /**
     * Met à jour le profil de l'utilisateur
     * 
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request)
    {
        $user = Auth::user();

        // Validation
        $validated = $request->validate([
            'firstname' => 'required|string|max:255',
            'lastname' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:users,username,' . $user->id,
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
        ], [
            'firstname.required' => 'Le prénom est obligatoire.',
            'lastname.required' => 'Le nom est obligatoire.',
            'username.required' => 'Le nom d\'utilisateur est obligatoire.',
            'username.unique' => 'Ce nom d\'utilisateur est déjà utilisé.',
            'email.required' => 'L\'email est obligatoire.',
            'email.unique' => 'Cet email est déjà utilisé.',
        ]);

        // Mise à jour de l'utilisateur
        $user->update($validated);

        return redirect()->route('profil')->with('success', 'Votre profil a été mis à jour.');
    }
}
