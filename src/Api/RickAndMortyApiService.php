<?php

namespace App\Api;

use Symfony\Contracts\HttpClient\HttpClientInterface;

class RickAndMortyApiService
{
    private $httpClient;

    public function __construct(HttpClientInterface $httpClient)
    {
        $this->httpClient = $httpClient->withOptions([
            'base_uri' => 'https://rickandmortyapi.com/api/'
        ]);
    }

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
