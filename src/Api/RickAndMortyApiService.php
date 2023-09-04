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

    public function getCharacters()
    {
        $charactersResponse = $this->httpClient->request('GET', 'https://rickandmortyapi.com/api/character');
        $charactersData = $charactersResponse->toArray();

        return $charactersData;
    }

    public function getEpisodes()
    {
        $episodesResponse = $this->httpClient->request('GET', 'https://rickandmortyapi.com/api/episode');
        $episodesData = $episodesResponse->toArray();

        return $episodesData;
    }

    public function getLocations()
    {
        $locationsResponse = $this->httpClient->request('GET', 'https://rickandmortyapi.com/api/location');
        $locationsData = $locationsResponse->toArray();
        return $locationsData;
    }
}