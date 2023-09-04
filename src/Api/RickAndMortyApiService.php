<?php

namespace App\Api;

require_once '../vendor/autoload.php';

use GuzzleHttp\Client;
use GuzzleHttp\Promise;

class RickAndMortyApiService
{
    private $client;

    public function __construct()
    {
        $this->client = new Client([
            'base_uri' => 'https://rickandmortyapi.com/',
            'timeout'  => 3.0,
        ]);
    }

    public function getCharacters()
    {
        $promises = [];

        // Crear múltiples solicitudes asincrónicas
        for ($i = 1; $i <= 42; $i++) {
            $url = "/api/character/?page={$i}";
            $promises[] = $this->client->requestAsync('GET', $url);
        }

       return $promises;
    }

    public function getLocations()
    {
        $promises = [];

        // Crear múltiples solicitudes asincrónicas
        for ($i = 1; $i <= 7; $i++) {
            $url = "/api/location/?page={$i}";
            $promises[] = $this->client->requestAsync('GET', $url);
        }

       return $promises;
    }

    public function getEpisodes()
    {
        $promises = [];

        // Crear múltiples solicitudes asincrónicas
        for ($i = 1; $i <= 3; $i++) {
            $url = "/api/episode/?page={$i}";
            $promises[] = $this->client->requestAsync('GET', $url);
        }

       return $promises;
    }

    public function getAllData(){
        // Initiate each request but do not block
        $promises = [
            'characters' => $this->getCharacters(),
            'locations'   => $this->getLocations(),
            'episodes'  => $this->getEpisodes()
        ];

        // Wait for the requests to complete, even if some of them fail
        $responses = Promise\Utils::settle($promises)->wait();

        dump( $responses);
    }

    
}

    
/* 
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
}*/
