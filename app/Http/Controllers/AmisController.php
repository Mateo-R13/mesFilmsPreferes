<?php

namespace App\Http\Controllers;

use App\Models\Ami;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class AmisController extends Controller
{
    public function index()
    {
        $userId = Auth::id();

        $mesAmisIds = Ami::where('user_id', $userId)->pluck('ami_id');
        $mesAmis    = User::whereIn('id', $mesAmisIds)->get();

        $autresUtilisateurs = User::where('id', '!=', $userId)->get();

        return view('amis.index', compact('mesAmis', 'autresUtilisateurs'));
    }

    public function add(User $user)
    {
        $userId = Auth::id();

        if ($user->id === $userId) {
            return back()->with('success', 'Tu ne peux pas t\'ajouter toi-même.');
        }

        $existe = Ami::where('user_id', $userId)
                     ->where('ami_id', $user->id)
                     ->exists();

        if (!$existe) {
            Ami::create(['user_id' => $userId, 'ami_id' => $user->id]);
            return back()->with('success', $user->username . ' ajouté à tes amis !');
        }

        return back()->with('success', 'Cet utilisateur est déjà ton ami.');
    }

    public function remove(User $user)
    {
        Ami::where('user_id', Auth::id())
           ->where('ami_id', $user->id)
           ->delete();

        return back()->with('success', $user->username . ' retiré de tes amis.');
    }
}
