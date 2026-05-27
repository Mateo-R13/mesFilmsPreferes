<?php

namespace App\Http\Controllers;

use App\Models\Ami;
use App\Models\Invitation;
use App\Models\User;
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

        $invitations = Invitation::where('user_id', $userId)->latest()->get();

        return view('amis.index', compact('amis', 'usersRecherche', 'mesAmisIds', 'invitations'));
    }

    public function add(User $user)
    {
        $userId = Auth::id();

        if ($user->id === $userId) {
            return back()->with('error', 'Tu ne peux pas t\'ajouter toi-même.');
        }

        DB::transaction(function () use ($userId, $user) {
            Ami::firstOrCreate(['user_id' => $userId, 'friend_id' => $user->id]);
            Ami::firstOrCreate(['user_id' => $user->id, 'friend_id' => $userId]);
        });

        return back()->with('success', $user->username . ' ajouté à tes amis !');
    }

    public function remove(User $user)
    {
        $userId = Auth::id();

        DB::transaction(function () use ($userId, $user) {
            Ami::where('user_id', $userId)->where('friend_id', $user->id)->delete();
            Ami::where('user_id', $user->id)->where('friend_id', $userId)->delete();
        });

        return back()->with('success', $user->username . ' retiré de tes amis.');
    }
}
