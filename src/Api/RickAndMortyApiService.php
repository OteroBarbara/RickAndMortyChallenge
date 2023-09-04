<?php

namespace App\Api;

use Symfony\Contracts\HttpClient\HttpClientInterface;
use Symfony\Contracts\HttpClient\ResponseInterface;

class RickAndMortyApiService
{
    private $httpClient;

    public function __construct(HttpClientInterface $httpClient)
    {
        $this->httpClient = $httpClient;
    }

    public function getCharacters()
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
    }

    public function getEpisodes()
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
    }

    public function getLocations()
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
    }
}
