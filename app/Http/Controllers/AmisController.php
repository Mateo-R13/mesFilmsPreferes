<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AmisController extends Controller
{
    /**
     * Affiche la liste des utilisateurs et de ses amis
     * 
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $user = Auth::user();
        
        // Récupérer les amis de l'utilisateur
        $amis = $user->amis()->get();
        
        // Récupérer tous les utilisateurs sauf l'utilisateur connecté
        $autresUtilisateurs = User::where('id', '!=', Auth::id())->get();
        
        return view('amis.index', [
            'amis' => $amis,
            'autresUtilisateurs' => $autresUtilisateurs,
        ]);
    }

    /**
     * Ajoute un utilisateur en tant qu'ami
     * 
     * @param User $user
     * @return \Illuminate\Http\RedirectResponse
     */
    public function add(User $user)
    {
        // Vérifier que l'utilisateur n'essaie pas de s'ajouter lui-même
        if ($user->id === Auth::id()) {
            return redirect()->back()->with('error', 'Vous ne pouvez pas vous ajouter vous-même comme ami.');
        }

        // Vérifier qu'il n'est pas déjà ami
        if (Auth::user()->amis()->where('friend_id', $user->id)->exists()) {
            return redirect()->back()->with('error', 'Vous êtes déjà amis avec cet utilisateur.');
        }

        // Ajouter l'ami
        Auth::user()->amis()->attach($user->id);

        return redirect()->back()->with('success', $user->username . ' a été ajouté à vos amis !');
    }

    /**
     * Retire un utilisateur de la liste des amis
     * 
     * @param User $user
     * @return \Illuminate\Http\RedirectResponse
     */
    public function remove(User $user)
    {
        // Vérifier qu'il est ami
        if (!Auth::user()->amis()->where('friend_id', $user->id)->exists()) {
            return redirect()->back()->with('error', 'Vous n\'aviez pas cet utilisateur en ami.');
        }

        // Retirer l'ami
        Auth::user()->amis()->detach($user->id);

        return redirect()->back()->with('success', $user->username . ' a été retiré de vos amis.');
    }
}
