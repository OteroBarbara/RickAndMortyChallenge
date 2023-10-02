<?php
// src/Service/RickAndMortyService.php

namespace App\Api;

use GuzzleHttp\Client;
use GuzzleHttp\Promise;

class RickAndMortyService
{
    private $apiUrl = 'https://rickandmortyapi.com/api/';

    public function fetchAllDataConcurrently()
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

    public function getCharacters()
    {
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
    }

    public function getEpisodes()
    {
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
    }

    public function getLocations()
    {
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
    }

    // Función para obtener datos y almacenar en caché
    function getDataWithCache($cacheFile, $cacheDurationInSeconds)
    {
        if (file_exists($cacheFile) && (time() - filemtime($cacheFile)) < $cacheDurationInSeconds) {
            // Si el archivo de caché existe y no ha expirado, devolver los datos en caché
            return json_decode(file_get_contents($cacheFile), true);
        } else {
            // Obtener los datos de manera concurrente utilizando la función existente
            $data = json_encode($this->fetchAllDataConcurrently());

            // Almacenar los datos en caché en un archivo
            file_put_contents($cacheFile, $data);

            return json_decode($data, true);
        }
    }

}
