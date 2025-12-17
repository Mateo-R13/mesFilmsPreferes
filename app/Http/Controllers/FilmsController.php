<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FilmsController extends Controller
{
    /**
     * Clé API TMDB
     * 
     * @var string
     */
    private $apiKey = '63905b28b94957ba2d061a85b849243f';
    private $baseUrl = 'https://api.themoviedb.org/3';

    /**
     * Affiche la page de recherche de films
     * 
     * @param Request $request
     * @return \Illuminate\View\View
     */
    public function search(Request $request)
    {
        $results = null;
        $error = null;
        $query = null;

        // Si une recherche est effectuée
        if ($request->has('query') && !empty($request->input('query'))) {
            $query = $request->input('query');

            try {
                // Encoder la requête pour l'URL
                $encodedQuery = urlencode($query);

                // Former l'URL d'appel à l'API TMDB
                $url = "{$this->baseUrl}/search/movie?query={$encodedQuery}&api_key={$this->apiKey}&language=fr&page=1";

                // Récupérer les données
                $response = @file_get_contents($url);

                if ($response === false) {
                    throw new \Exception('Erreur lors de la requête à l\'API TMDB.');
                }

                // Décoder la réponse JSON
                $data = json_decode($response, true);

                // Vérifier qu'il y a des résultats
                if (isset($data['results']) && count($data['results']) > 0) {
                    $results = $data['results'];
                } else {
                    $error = 'Aucun film trouvé pour "' . htmlspecialchars($query) . '".';
                }

            } catch (\Exception $e) {
                $error = 'Erreur : ' . $e->getMessage();
            }
        }

        return view('films.search', [
            'results' => $results,
            'error' => $error,
            'query' => $query,
        ]);
    }

    /**
     * Ajoute un film aux favoris depuis les résultats de recherche
     * 
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function addFavori(Request $request)
    {
        // Vérifier l'authentification
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Veuillez vous connecter pour ajouter des favoris.');
        }

        // Validation
        $validated = $request->validate([
            'favori_id' => 'required',
            'film_title' => 'required|string|max:255',
            'film_year' => 'nullable|string',
            'film_overview' => 'nullable|string',
            'film_poster_path' => 'nullable|string',
        ]);

        // Réorienter vers le stockage du favori
        return redirect()->route('favoris.add')
            ->with('data', $validated);
    }
}
