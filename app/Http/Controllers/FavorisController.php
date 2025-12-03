<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class FavorisController extends Controller
{
    public function afficherFavoris()
    {
        return view('favoris');
    }
    public function supprimerFavoris()
    {
        return view('connexion');
    }
}