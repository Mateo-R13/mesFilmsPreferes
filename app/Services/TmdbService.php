<?php

namespace App\Services;

use Illuminate\Support\Facades\Log;

class TmdbService
{
    private string $apiKey;
    private string $baseUrl = 'https://api.themoviedb.org/3';
    private string $lang    = 'fr-FR';

    public function __construct()
    {
        $this->apiKey = config('services.tmdb.key', env('TMDB_API_KEY', ''));
    }

    public function searchMovies(string $query): array
    {
        $url = "{$this->baseUrl}/search/movie?"
             . http_build_query([
                 'query'    => $query,
                 'api_key'  => $this->apiKey,
                 'language' => $this->lang,
             ]);

        return $this->fetch($url)['results'] ?? [];
    }

    public function getMovie(int $tmdbId): ?array
    {
        $url = "{$this->baseUrl}/movie/{$tmdbId}?"
             . http_build_query([
                 'api_key'             => $this->apiKey,
                 'language'            => $this->lang,
                 'append_to_response'  => 'credits',
             ]);

        $data = $this->fetch($url);

        return isset($data['id']) ? $data : null;
    }

    private function fetch(string $url): array
    {
        if (empty($this->apiKey)) {
            Log::error('TMDB : clé API manquante dans .env (TMDB_API_KEY)');
            return ['_error' => 'clé_manquante'];
        }

        if (!function_exists('curl_init')) {
            // Fallback file_get_contents si cURL absent
            $ctx = stream_context_create(['http' => [
                'timeout'       => 8,
                'ignore_errors' => true,
            ]]);
            $response = @file_get_contents($url, false, $ctx);
        } else {
            $ch = curl_init();
            curl_setopt_array($ch, [
                CURLOPT_URL            => $url,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_TIMEOUT        => 8,
                CURLOPT_SSL_VERIFYPEER => false,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTPHEADER     => ['Accept: application/json'],
            ]);
            $response = curl_exec($ch);
            $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            $curlError = curl_error($ch);
            curl_close($ch);

            if ($curlError) {
                Log::error('TMDB cURL error : ' . $curlError);
                return [];
            }

            if ($httpCode !== 200) {
                Log::error("TMDB HTTP {$httpCode} pour : {$url}");
                return [];
            }
        }

        if ($response === false || $response === null) {
            Log::error('TMDB : réponse vide pour ' . $url);
            return [];
        }

        return json_decode($response, true) ?? [];
    }
}
