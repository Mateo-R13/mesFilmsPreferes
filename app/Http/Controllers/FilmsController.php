<?php

namespace App\Http\Controllers;

use App\Models\Favori;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FilmsController extends Controller
{
    public function search(Request $request)
    {
        $results = null;
        $error   = null;

        if ($request->filled('query')) {
            try {
                $apiKey  = env('TMDB_API_KEY', '63905b28b94957ba2d061a85b849243f');
                $query   = urlencode($request->input('query'));
                $url     = "https://api.themoviedb.org/3/search/movie?query={$query}&api_key={$apiKey}&language=fr-FR";
                $response = @file_get_contents($url);

                if ($response === false) {
                    throw new \Exception('Impossible de contacter l\'API TMDB.');
                }

                $data = json_decode($response, true);

                if (isset($data['results'])) {
                    $results = $data['results'];
                } else {
                    $error = 'Aucun film trouvé.';
                }
            } catch (\Exception $e) {
                $error = $e->getMessage();
            }
        }

        return view('films.rechercher', compact('results', 'error'));
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
                'affiche'   => $request->affiche ?? null,
                'annee'     => $request->annee ?? null,
                'note_tmdb' => $request->note_tmdb ?? null,
            ]);

            return back()->with('success', '« ' . $request->titre . ' » ajouté à tes favoris !');
        }

        return back()->with('success', 'Ce film est déjà dans tes favoris.');
    }
}
