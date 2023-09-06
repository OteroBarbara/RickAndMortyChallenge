<?php

namespace App\Api;

use Symfony\Contracts\HttpClient\HttpClientInterface;

/**
 * Servicio que se encarga de interactuar con la API de Rick and Morty para obtener datos relacionados con personajes, episodios y ubicaciones.
 */
class RickAndMortyApiService
{
    /**
     * @var HttpClientInterface Cliente HTTP para realizar solicitudes a la API.
     */
    private $httpClient;

    /**
     * Constructor de la clase.
     *
     * @param HttpClientInterface $httpClient Cliente HTTP para realizar solicitudes a la API.
     */
    public function __construct(HttpClientInterface $httpClient)
    {
        $this->httpClient = $httpClient->withOptions([
            'base_uri' => 'https://rickandmortyapi.com/api/'
        ]);
    }

    /**
     * Obtiene información sobre los personajes de Rick and Morty.
     *
     * @return array Arreglo de datos de personajes.
     */
    public function getCharacters()
    {
        $characters = [];
        $uri = 'character';

        do {
            $charactersResponse = $this->httpClient->request('GET', $uri);
            $charactersData = $charactersResponse->toArray();
            $characters = array_merge($characters, $charactersData['results']);
            $uri = $charactersData['info']['next'];
        } while (!is_null($uri));

        return $characters;
    }

    /**
     * Obtiene información sobre los episodios de Rick and Morty.
     *
     * @return array Arreglo de datos de episodios.
     */
    public function getEpisodes()
    {
        $episodes = [];
        $uri = 'episode';

        do {
            $episodesResponse = $this->httpClient->request('GET', $uri);
            $episodesData = $episodesResponse->toArray();
            $episodes = array_merge($episodes, $episodesData['results']);
            $uri = $episodesData['info']['next'];
        } while (!is_null($uri));

        return $episodes;
    }

    /**
     * Obtiene información sobre las ubicaciones de Rick and Morty.
     *
     * @return array Arreglo de datos de ubicaciones.
     */
    public function getLocations()
    {
        $locations = [];
        $uri = 'location';

        do {
            $locationsResponse = $this->httpClient->request('GET', $uri);
            $locationsData = $locationsResponse->toArray();
            $locations = array_merge($locations, $locationsData['results']);
            $uri = $locationsData['info']['next'];
        } while (!is_null($uri));

        return $locations;
    }
    

}
