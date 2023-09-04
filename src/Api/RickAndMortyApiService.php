<?php

namespace App\Api;

use Symfony\Contracts\HttpClient\HttpClientInterface;

class RickAndMortyApiService
{
    private $httpClient;

    public function __construct(HttpClientInterface $httpClient)
    {
        $this->httpClient = $httpClient;
    }

    /* public function getCharacters()
    {
        $characters = [];
        $url = 'https://rickandmortyapi.com/api/character';

        do {
            $charactersResponse = $this->httpClient->request('GET', $url);
            $charactersData = $charactersResponse->toArray();
            $characters = array_merge($characters, $charactersData['results']);
            $url = $charactersData['info']['next'];
        } while (!is_null($url));

        return $characters;
    } */

    public function getCharacters()
    {
        return $this->getCharactersRec('https://rickandmortyapi.com/api/character');
    }

    private function getCharactersRec($url, $characters = [])
    {
        $charactersResponse = $this->httpClient->request('GET', $url);
        $charactersData = $charactersResponse->toArray();
        $nextPageUrl = $charactersData['info']['next'];

        if (!is_null($nextPageUrl)) {
            // Llamada recursiva para obtener la siguiente página
            $characters = $this->getCharactersRec($nextPageUrl, $characters);
        }

        $characters = array_merge($characters, $charactersData['results']);

        return $characters;
    }

    /* public function getEpisodes()
    {
        $episodes = [];
        $url = 'https://rickandmortyapi.com/api/episode';

        do {
            $episodesResponse = $this->httpClient->request('GET', $url);
            $episodesData = $episodesResponse->toArray();
            $episodes = array_merge($episodes, $episodesData['results']);
            $url = $episodesData['info']['next'];
        } while (!is_null($url));

        return $episodes;
    } */

    public function getEpisodes()
    {
        return $this->getEpisodesRec('https://rickandmortyapi.com/api/episode');
    }

    private function getEpisodesRec($url, $episodes = [])
    {
        $episodesResponse = $this->httpClient->request('GET', $url);
        
        $episodesData = $episodesResponse->toArray();

        $nextPageUrl = $episodesData['info']['next'];

        if (!is_null($nextPageUrl)) {
            // Llamada recursiva para obtener la siguiente página
            $episodes = $this->getEpisodesRec($nextPageUrl, $episodes);
        }
        
        $episodes = array_merge($episodes, $episodesData['results']);

        return $episodes;
    }

    /* public function getLocations()
    {
        $locations = [];
        $url = 'https://rickandmortyapi.com/api/location';

        do {
            $locationsResponse = $this->httpClient->request('GET', $url);
            $locationsData = $locationsResponse->toArray();
            $locations = array_merge($locations, $locationsData['results']);
            $url = $locationsData['info']['next'];
        } while (!is_null($url));

        return $locations;
    } */

    public function getLocations()
    {
        return $this->getLocationsRec('https://rickandmortyapi.com/api/location');
    }

    private function getLocationsRec($url, $locations = [])
    {
        $locationsResponse = $this->httpClient->request('GET', $url);
        $locationsData = $locationsResponse->toArray();

        $nextPageUrl = $locationsData['info']['next'];

        if (!is_null($nextPageUrl)) {
            // Llamada recursiva para obtener la siguiente página
            $locations = $this->getLocationsRec($nextPageUrl, $locations);
        }

        $locations = array_merge($locations, $locationsData['results']);

        return $locations;
    }
}
