<?php

namespace App\Services;

class TmdbService
{
    private string $apiKey;
    private string $baseUrl = 'https://api.themoviedb.org/3';
    private string $lang = 'fr-FR';

    public function __construct()
    {
        $this->apiKey = env('TMDB_API_KEY', '');
    }

    public function searchMovies(string $query): array
    {
        $url = "{$this->baseUrl}/search/movie?query=" . urlencode($query)
             . "&api_key={$this->apiKey}&language={$this->lang}";

        return $this->fetch($url)['results'] ?? [];
    }

    public function getMovie(int $tmdbId): ?array
    {
        $url = "{$this->baseUrl}/movie/{$tmdbId}"
             . "?api_key={$this->apiKey}&language={$this->lang}"
             . "&append_to_response=credits";

        $data = $this->fetch($url);

        return isset($data['id']) ? $data : null;
    }

    private function fetch(string $url): array
    {
        $ctx = stream_context_create(['http' => [
            'timeout'        => 5,
            'ignore_errors'  => true,
        ]]);

        $response = @file_get_contents($url, false, $ctx);

        if ($response === false) {
            return [];
        }

        return json_decode($response, true) ?? [];
    }
}
