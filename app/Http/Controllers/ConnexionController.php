<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ConnexionController extends Controller
{
    public function afficherFormulaireConnexion()
    {
        return view('connexion');
    }

    public function afficherFormulaireInscription()
    {
        return view('inscription');
    }

    public function traiterConnexion(Request $request)
    {
        $request->validate(['email' => ['required', 'email', 'confirmed']
        ,]);
    }
    
}
?>