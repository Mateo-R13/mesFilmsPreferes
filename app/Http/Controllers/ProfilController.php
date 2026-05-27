<?php

namespace App\Http\Controllers;

use App\Models\Ami;
use App\Models\Avis;
use App\Models\Favori;
use App\Models\Partage;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class ProfilController extends Controller
{
    public function show()
    {
        $user        = Auth::user();
        $nbAvis      = Avis::where('user_id', $user->id)->count();
        $noteMoyenne = Avis::where('user_id', $user->id)->avg('note');

        $stats = [
            'favoris'      => Favori::where('user_id', $user->id)->count(),
            'avis'         => $nbAvis,
            'note_moyenne' => $noteMoyenne ? round($noteMoyenne, 1) : null,
            'amis'         => Ami::where('user_id', $user->id)->count(),
            'partages'     => Partage::where('user_id', $user->id)->count(),
        ];

        $derniersFavoris = Favori::where('user_id', $user->id)->latest()->take(8)->get();

        return view('profil.show', compact('user', 'stats', 'derniersFavoris'));
    }

    public function showAmi(User $user)
    {
        $moi = Auth::id();

        $estAmi = Ami::where('user_id', $moi)
                     ->where('friend_id', $user->id)
                     ->exists();

        if (!$estAmi && $user->id !== $moi) {
            abort(403, 'Tu ne peux voir que le profil de tes amis.');
        }

        if ($user->id === $moi) {
            return redirect()->route('profil');
        }

        $nbAvis      = Avis::where('user_id', $user->id)->count();
        $noteMoyenne = Avis::where('user_id', $user->id)->avg('note');

        $stats = [
            'favoris'      => Favori::where('user_id', $user->id)->count(),
            'avis'         => $nbAvis,
            'note_moyenne' => $noteMoyenne ? round($noteMoyenne, 1) : null,
            'amis'         => Ami::where('user_id', $user->id)->count(),
        ];

        $favoris = Favori::with('avis')->where('user_id', $user->id)->latest()->get();

        return view('profil.ami', compact('user', 'stats', 'favoris', 'estAmi'));
    }

    public function edit()
    {
        return view('profil.edit', ['user' => Auth::user()]);
    }

    public function update(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'firstname' => ['required', 'string', 'max:100', 'regex:/^[\p{L}\s\-\']+$/u'],
            'lastname'  => ['required', 'string', 'max:100', 'regex:/^[\p{L}\s\-\']+$/u'],
            'username'  => ['required', 'string', 'max:50', 'regex:/^[a-zA-Z0-9_\.\-]+$/', Rule::unique('users')->ignore($user->id)],
            'email'     => ['required', 'email:rfc', 'max:255', Rule::unique('users')->ignore($user->id)],
            'password'  => ['nullable', 'string', 'min:8', 'max:255', 'confirmed'],
        ]);

        $user->firstname = strip_tags($request->firstname);
        $user->lastname  = strip_tags($request->lastname);
        $user->username  = strip_tags($request->username);
        $user->email     = $request->email;

        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }

        $user->save();

        return redirect()->route('profil')->with('success', 'Profil mis à jour !');
    }

    public function destroy(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'password' => ['required', 'string'],
        ]);

        if (!Hash::check($request->password, $user->password)) {
            return back()->withErrors(['password' => 'Mot de passe incorrect.']);
        }

        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        $user->delete();

        return redirect('/')->with('success', 'Ton compte a été supprimé.');
    }
}
