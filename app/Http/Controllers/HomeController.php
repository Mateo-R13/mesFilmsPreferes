<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class HomeController extends Controller
{
    /**
     * Affiche la page d'accueil
     * 
     * @return \Illuminate\View\View
     */
    public function index()
    {
        // Si l'utilisateur est connecté, afficher des infos
        if (Auth::check()) {
            $user = Auth::user();
            $nbFavoris = $user->favoris()->count();
            $nbAmis = $user->amis()->count();
            $nbPartages = $user->partageurParAmis()->count();

            return view('home.index', [
                'user' => $user,
                'nbFavoris' => $nbFavoris,
                'nbAmis' => $nbAmis,
                'nbPartages' => $nbPartages,
            ]);
        }

        // Sinon, afficher la page d'accueil publique
        return view('home.welcome');
    }
}
