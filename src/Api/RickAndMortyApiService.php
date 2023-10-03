<?php

namespace App\Api;

use App\Service\CacheService;
use Symfony\Contracts\HttpClient\HttpClientInterface;

/**
 * Servicio que se encarga de interactuar con la API de Rick and Morty
 * para obtener datos relacionados con personajes, episodios y ubicaciones.
 */
class RickAndMortyApiService
{
    /**
     * @var HttpClientInterface Cliente HTTP para realizar solicitudes a la API.
     */
    private $httpClient;

    /**
     * @var CacheService Una instancia de CacheService para la gestión de caché de datos.
     */
    private $cacheService;

    /**
     * Constructor de la clase.
     *
     * @param HttpClientInterface $httpClient Cliente HTTP para realizar solicitudes a la API.
     * @param CacheService $cacheService Una instancia de CacheService para la gestión de caché de datos.
     *
     */
    public function __construct(HttpClientInterface $httpClient, CacheService $cacheService)
    {
        $this->httpClient = $httpClient->withOptions([
            'base_uri' => 'https://rickandmortyapi.com/api/'
        ]);
        $this->cacheService = $cacheService;
    }

    /**
     * Obtiene información sobre los personajes de Rick and Morty, con almacenamiento en caché.
     *
     * @return array Arreglo de datos de personajes.
     */
    public function getCharacters()
    {
        return $this->cacheService->get('characters_cache.json', 3600, function () {
            $characters = [];
            $uri = 'character';

            do {
                $charactersResponse = $this->httpClient->request('GET', $uri);
                $charactersData = $charactersResponse->toArray();
                $characters = array_merge($characters, $charactersData['results']);
                $uri = $charactersData['info']['next'];
            } while (!is_null($uri));

            return $characters;
        });
    }

    /**
     * Obtiene información sobre los episodios de Rick and Morty, con almacenamiento en caché.
     *
     * @return array Arreglo de datos de episodios.
     */
    public function getEpisodes()
    {
        return $this->cacheService->get('episodes_cache.json', 3600, function () {
            $episodes = [];
            $uri = 'episode';

            do {
                $episodesResponse = $this->httpClient->request('GET', $uri);
                $episodesData = $episodesResponse->toArray();
                $episodes = array_merge($episodes, $episodesData['results']);
                $uri = $episodesData['info']['next'];
            } while (!is_null($uri));

            return $episodes;
        });
    }

    /**
     * Obtiene información sobre las ubicaciones de Rick and Morty, con almacenamiento en caché.
     *
     * @return array Arreglo de datos de ubicaciones.
     */
    public function getLocations()
    {
        return $this->cacheService->get('locations_cache.json', 3600, function () {
            $locations = [];
            $uri = 'location';

            do {
                $locationsResponse = $this->httpClient->request('GET', $uri);
                $locationsData = $locationsResponse->toArray();
                $locations = array_merge($locations, $locationsData['results']);
                $uri = $locationsData['info']['next'];
            } while (!is_null($uri));

            return $locations;
        });
    }
    
    /**
     * Obtiene todos los datos de personajes, episodios y ubicaciones de la API de Rick and Morty.
     *
     * @return array Un arreglo con datos de personajes, episodios y ubicaciones.
     */
    public function getAllData()
    {
        return ([
            'characters' => $this->getCharacters(),
            'episodes' => $this->getEpisodes(),
            'locations' => $this->getLocations()
        ]);
    }
}
