<?php

namespace App\Http\Controllers;

use App\Models\Ami;
use App\Models\Avis;
use App\Models\Favori;
use App\Models\Partage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfilController extends Controller
{
    public function show()
    {
        $userId = Auth::id();

        $stats = [
            'nb_favoris'  => Favori::where('user_id', $userId)->count(),
            'nb_avis'     => Avis::where('user_id', $userId)->count(),
            'nb_amis'     => Ami::where('user_id', $userId)->count(),
            'nb_partages' => Partage::where('user_id', $userId)->count(),
        ];

        return view('profil.show', compact('stats'));
    }

    public function edit()
    {
        return view('profil.edit');
    }

    public function update(Request $request)
    {
        $user = Auth::user();

        $rules = [
            'firstname' => ['required', 'string', 'max:255'],
            'lastname'  => ['required', 'string', 'max:255'],
            'username'  => ['required', 'string', 'max:255', 'unique:users,username,' . $user->id],
            'email'     => ['required', 'string', 'email', 'max:255', 'unique:users,email,' . $user->id],
        ];

        if ($request->filled('password')) {
            $rules['password'] = ['required', 'string', 'min:8', 'confirmed'];
        }

        $request->validate($rules);

        $user->firstname = $request->firstname;
        $user->lastname  = $request->lastname;
        $user->username  = $request->username;
        $user->email     = $request->email;

        if ($request->filled('password')) {
            $user->password = bcrypt($request->password);
        }

        $user->save();

        return redirect(route('profil'))->with('success', 'Profil mis à jour avec succès !');
    }
}
