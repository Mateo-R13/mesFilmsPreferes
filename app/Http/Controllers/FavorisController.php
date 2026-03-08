<?php

namespace App\Http\Controllers;

use App\Models\Ami;
use App\Models\Favori;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FavorisController extends Controller
{
    public function index(Request $request)
    {
        $query = Favori::with('avis')->where('user_id', Auth::id());

        switch ($request->input('tri', 'recent')) {
            case 'note':
                $query->orderByDesc('note_tmdb');
                break;
            case 'titre':
                $query->orderBy('titre');
                break;
            default:
                $query->latest();
        }

        $favoris = $query->get();

        // Liste des amis pour le bouton "Partager" sur chaque carte
        $mesAmisIds = Ami::where('user_id', Auth::id())->pluck('friend_id');
        $amis = User::whereIn('id', $mesAmisIds)->get();

        return view('favoris.index', compact('favoris', 'amis'));
    }

    public function store()
    {
        return redirect()->route('favoris');
    }

    public function destroy(Favori $favori)
    {
        if ($favori->user_id !== Auth::id()) abort(403);
        $favori->delete();
        return back()->with('success', '"' . $favori->titre . '" retiré de tes favoris.');
    }
}
