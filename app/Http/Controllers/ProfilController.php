<?php

namespace App\Http\Controllers;

use App\Models\Ami;
use App\Models\Avis;
use App\Models\Favori;
use App\Models\Partage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class ProfilController extends Controller
{
    public function show()
    {
        $user = Auth::user();

        $nbAvis      = Avis::where('user_id', $user->id)->count();
        $noteMoyenne = Avis::where('user_id', $user->id)->avg('note');

        $stats = [
            'favoris'      => Favori::where('user_id', $user->id)->count(),
            'avis'         => $nbAvis,
            'note_moyenne' => $noteMoyenne ? round($noteMoyenne, 1) : null,
            'amis'         => Ami::where('user_id', $user->id)->count(), // ✅ friend_id utilisé dans AmisController
            'partages'     => Partage::where('expediteur_id', $user->id)->count(),
        ];

        $derniersFavoris = Favori::where('user_id', $user->id)->latest()->take(8)->get();

        return view('profil.show', compact('user', 'stats', 'derniersFavoris'));
    }

    public function edit()
    {
        return view('profil.edit', ['user' => Auth::user()]);
    }

    public function update(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'firstname' => ['required', 'string', 'max:100'],
            'lastname'  => ['required', 'string', 'max:100'],
            'username'  => ['required', 'string', 'max:50', Rule::unique('users')->ignore($user->id)],
            'email'     => ['required', 'email', Rule::unique('users')->ignore($user->id)],
            'password'  => ['nullable', 'string', 'min:8', 'confirmed'],
        ]);

        $user->firstname = $request->firstname;
        $user->lastname  = $request->lastname;
        $user->username  = $request->username;
        $user->email     = $request->email;

        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }

        $user->save();

        return redirect()->route('profil')->with('success', 'Profil mis à jour !');
    }
}
