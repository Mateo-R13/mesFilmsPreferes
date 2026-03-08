<?php

namespace App\Http\Controllers;

use App\Models\Favori;
use Illuminate\Support\Facades\Auth;

class FavorisController extends Controller
{
    public function index()
    {
        $favoris = Favori::where('user_id', Auth::id())
                         ->with('avis')
                         ->latest()
                         ->get();

        return view('favoris.index', compact('favoris'));
    }

    public function store()
    {
        // handled by FilmsController::addFavori
    }

    public function destroy(Favori $favori)
    {
        if ($favori->user_id !== Auth::id()) {
            abort(403);
        }

        $favori->delete();

        return back()->with('success', 'Film retiré de tes favoris.');
    }
}
