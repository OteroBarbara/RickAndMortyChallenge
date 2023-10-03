<?php

namespace App\Api;

use App\Service\CacheService;
use GuzzleHttp\Client;
use GuzzleHttp\Promise;

/**
 * RickAndMortyAsyncService proporciona métodos para recuperar datos de la API de Rick and Morty de forma asíncrona.
 */
class RickAndMortyAsyncService
{
    /**
     * @var string La URL base de la API de Rick and Morty.
     */
    private $apiUrl = 'https://rickandmortyapi.com/api/';

    /**
     * @var CacheService Una instancia de CacheService para la gestión de caché de datos.
     */
    private $cacheService;

    /**
     * Constructor de la clase RickAndMortyAsyncService.
     *
     * @param CacheService $cacheService Una instancia de CacheService para la gestión de caché de datos.
     */
    public function __construct(CacheService $cacheService)
    {
        $this->cacheService = $cacheService;
    }

    /**
     * Obtiene todos los datos de personajes, episodios y ubicaciones de la API de Rick and Morty.
     *
     * @return array Un arreglo con datos de personajes, episodios y ubicaciones.
     */
    public function getAllData()
    {
        $promises = [
            'characters' => $this->getCharacters(),
            'episodes' => $this->getEpisodes(),
            'locations' => $this->getLocations(),
        ];

        $responses = Promise\Utils::settle($promises)->wait();
        
        $results = [
            'characters' => [],
            'episodes' => [],
            'locations' => [],
        ];
    
        foreach ($responses as $key => $response) {
            if ($response['state'] === 'fulfilled') {
                $response = $response['value'];
                $results[$key] = $response;
            }
        }

        return $results;
    }

    /**
     * Obtiene datos de personajes de la API de Rick and Morty, con almacenamiento en caché.
     *
     * @return array Un arreglo de datos de personajes.
     */
    public function getCharacters()
    {
        return $this->cacheService->get('characters_cache.json', 3600, function () {
            $characters = [];
            $uri = 'character';
            $client = new Client(['base_uri' => $this->apiUrl]);

            try {
                $promises = [];
                for ($i = 1; $i < 43; $i++) { // Adjust the concurrency level as needed
                    if (!is_null($uri)) {
                        $promises[] = $client->getAsync($uri."/?page=".$i);
                    }
                }

                // Wait for all promises to complete
                $responses = Promise\Utils::settle($promises)->wait();
                foreach ($responses as $response) {
                    if ($response['state'] === 'fulfilled') {
                        $response = $response['value'];
                        $charactersData = json_decode($response->getBody()->getContents(), true);
                        $characters = array_merge($characters, $charactersData['results']);
                    }
                }

            } catch (\Throwable $th) {
                throw $th;
            }

            return $characters;
        });
    }

    /**
     * Obtiene datos de episodios de la API de Rick and Morty, con almacenamiento en caché.
     *
     * @return array Un arreglo de datos de episodios.
     */
    public function getEpisodes()
    {
        return $this->cacheService->get('episodes_cache.json', 3600, function () {
            $client = new Client(['base_uri' => $this->apiUrl]);

            $episodes = [];
            $uri = 'episode';

            try {
                $promises = [];
                for ($i = 1; $i < 4; $i++) { 
                    $promises[] = $client->getAsync($uri."/?page=".$i);
                }

                // Wait for all promises to complete
                $responses = Promise\Utils::settle($promises)->wait();
                foreach ($responses as $response) {
                    if ($response['state'] === 'fulfilled') {
                        $response = $response['value'];
                        $episodesData = json_decode($response->getBody()->getContents(), true);
                        $episodes = array_merge($episodes, $episodesData['results']);
                    }
                }

            } catch (\Throwable $th) {
                throw $th;
            }

            return $episodes;
        });
    }

    /**
     * Obtiene datos de ubicaciones de la API de Rick and Morty, con almacenamiento en caché.
     *
     * @return array Un arreglo de datos de ubicaciones.
     */
    public function getLocations()
    {
        return $this->cacheService->get('locations_cache.json', 3600, function () {
            $client = new Client(['base_uri' => $this->apiUrl]);

            $locations = [];
            $uri = 'location';

            try {
                $promises = [];
                for ($i = 1; $i < 8; $i++) { 
                    $promises[] = $client->getAsync($uri."/?page=".$i);
                }

                // Wait for all promises to complete
                $responses = Promise\Utils::settle($promises)->wait();
                foreach ($responses as $response) {
                    if ($response['state'] === 'fulfilled') {
                        $response = $response['value'];
                        $locationsData = json_decode($response->getBody()->getContents(), true);
                        $locations = array_merge($locations, $locationsData['results']);
                    }
                }

            } catch (\Throwable $th) {
                throw $th;
            }

            return $locations;
        });
    }

}
