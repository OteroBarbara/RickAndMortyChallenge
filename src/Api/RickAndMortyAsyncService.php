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
     * @var Client Cliente HTTP (Guzzle) para realizar solicitudes a la API.
     */
    private $client;

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
        $this->client = new Client([
            'base_uri' => 'https://rickandmortyapi.com/',
            'timeout'  => 3.0,
        ]);
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

        // Espera que se cumplan las promesas
        $responses = Promise\Utils::settle($promises)->wait();
    
        // Arma el arreglo de resultados
        foreach ($responses as $key => $response) {
            if ($response['state'] === 'fulfilled') {
                $response = $response['value'];
                $responses[$key] = $response;
            }
        }

        return $responses;
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
            $uri = '/api/character';

            try {
                $promises = [];
                for ($i = 1; $i <= 42; $i++) { // Itera tantas veces como la cantidad de páginas
                    if (!is_null($uri)) {
                        $promises[] = $this->client->getAsync($uri."/?page=".$i);
                    }
                }

                // Espera que se cumplan las promesas
                $responses = Promise\Utils::settle($promises)->wait();

                // Arma el arreglo de resultados
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

            $episodes = [];
            $uri = '/api/episode';

            try {
                $promises = [];
                for ($i = 1; $i <= 3; $i++) { // Itera tantas veces como la cantidad de páginas
                    $promises[] = $this->client->getAsync($uri."/?page=".$i);
                }

                // Espera que se cumplan las promesas
                $responses = Promise\Utils::settle($promises)->wait();

                // Arma el arreglo de resultados
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

            $locations = [];
            $uri = '/api/location';

            try {
                $promises = [];
                for ($i = 1; $i <= 7; $i++) {  // Itera tantas veces como la cantidad de páginas
                    $promises[] = $this->client->getAsync($uri."/?page=".$i);
                }

                // Espera que se cumplan las promesas
                $responses = Promise\Utils::settle($promises)->wait();

                // Arma el arreglo de resultados
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
