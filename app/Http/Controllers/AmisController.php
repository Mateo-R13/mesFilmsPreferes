<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Ami;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AmisController extends Controller
{
    public function index(Request $request)
    {
        $userId = Auth::id();

        $mesAmisIds = Ami::where('user_id', $userId)->pluck('friend_id');
        $amis = User::whereIn('id', $mesAmisIds)->get();

        $usersRecherche = collect();
        if ($request->filled('search')) {
            $q = $request->input('search');
            $usersRecherche = User::where('id', '!=', $userId)
                ->where(function ($query) use ($q) {
                    $query->where('username', 'like', "%{$q}%")
                          ->orWhere('email', 'like', "%{$q}%")
                          ->orWhere('firstname', 'like', "%{$q}%")
                          ->orWhere('lastname', 'like', "%{$q}%");
                })
                ->get();
        }

        return view('amis.index', compact('amis', 'usersRecherche', 'mesAmisIds'));
    }

    public function add(User $user)
    {
        $userId = Auth::id();

        if ($user->id === $userId) {
            return back()->with('error', 'Tu ne peux pas t\'ajouter toi-même.');
        }

        DB::transaction(function () use ($userId, $user) {
            // Lien A -> B
            Ami::firstOrCreate([
                'user_id'   => $userId,
                'friend_id' => $user->id,
            ]);
            // Lien réciproque B -> A
            Ami::firstOrCreate([
                'user_id'   => $user->id,
                'friend_id' => $userId,
            ]);
        });

        return back()->with('success', $user->username . ' ajouté à tes amis !');
    }

    public function remove(User $user)
    {
        $userId = Auth::id();

        DB::transaction(function () use ($userId, $user) {
            // Suppression A -> B
            Ami::where('user_id', $userId)
               ->where('friend_id', $user->id)
               ->delete();
            // Suppression réciproque B -> A
            Ami::where('user_id', $user->id)
               ->where('friend_id', $userId)
               ->delete();
        });

        return back()->with('success', $user->username . ' retiré de tes amis.');
    }
}
