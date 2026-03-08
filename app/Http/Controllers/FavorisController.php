<?php

namespace App\Http\Controllers;

use App\Models\Favori;
use Illuminate\Support\Facades\Auth;

class FavorisController extends Controller
{
    public function index()
    {
        $favoris = Favori::with('avis')
            ->where('user_id', Auth::id())
            ->latest()
            ->get();

        return view('favoris.index', compact('favoris'));
    }

    public function store()
    {
        // Géré dans FilmsController::addFavori
        return redirect()->route('favoris');
    }

    public function destroy(Favori $favori)
    {
        if ($favori->user_id !== Auth::id()) {
            abort(403);
        }

        $favori->delete();

        return back()->with('success', '"' . $favori->titre . '" retiré de tes favoris.');
    }
}
