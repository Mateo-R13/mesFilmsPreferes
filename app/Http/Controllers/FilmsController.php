<?php

namespace App\Http\Controllers;

use App\Models\Favori;
use App\Services\TmdbService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FilmsController extends Controller
{
    public function __construct(private TmdbService $tmdb) {}

    public function search(Request $request)
    {
        $results = null;
        $error   = null;

        if ($request->filled('query')) {
            $data = $this->tmdb->searchMovies($request->input('query'));

            if (empty($data)) {
                $error = 'Aucun film trouvé pour cette recherche, ou l\'API TMDB est inaccessible.';
            } else {
                $results = $data;
            }
        }

        return view('films.rechercher', compact('results', 'error'));
    }

    public function show(int $tmdbId)
    {
        $film = $this->tmdb->getMovie($tmdbId);

        if (!$film) {
            abort(404, 'Film introuvable.');
        }

        $dejaEnFavori = Favori::where('user_id', Auth::id())
                              ->where('tmdb_id', $tmdbId)
                              ->exists();

        return view('films.show', compact('film', 'dejaEnFavori'));
    }

    public function addFavori(Request $request)
    {
        $request->validate([
            'tmdb_id' => ['required', 'integer'],
            'titre'   => ['required', 'string', 'max:255'],
        ]);

        $existe = Favori::where('user_id', Auth::id())
                        ->where('tmdb_id', $request->tmdb_id)
                        ->exists();

        if (!$existe) {
            Favori::create([
                'user_id'   => Auth::id(),
                'tmdb_id'   => $request->tmdb_id,
                'titre'     => $request->titre,
                'synopsis'  => $request->synopsis ?? null,
                'affiche'   => $request->affiche ?? null,
                'annee'     => $request->annee ?? null,
                'note_tmdb' => $request->note_tmdb ?? null,
            ]);
            return back()->with('success', '« ' . $request->titre . ' » ajouté à tes favoris !');
        }

        return back()->with('success', 'Ce film est déjà dans tes favoris.');
    }
}
