<?php

namespace App\Service;

class EpisodeLocationService
{
    public function getLocations(array $jsonEpisodesList, array $jsonCharactersList)
    {
        $results = [];
        // Recorrer la lista    
        foreach ($jsonEpisodesList as $jsonEpisode) {

            $characterLocations = [];

            // Obtener el valor, es un endpoint donde consultar la información del personaje
            $charactersUrls = $jsonEpisode["characters"];

            foreach ($charactersUrls as $url) {
                // Ya disponemos de la lista de personajes, así que nos quedamos con la parte de la url que representa el ID
                $characterId = basename(strrchr($url, "/"));
                // Con el ID consultamos la locación de origen del personaje en el arreglo que disponemos
                array_push($characterLocations,$jsonCharactersList[$characterId-1]["origin"]["name"]);
            }

            // Eliminamos los duplicados y lo convertimos en un arreglo indexado (sin claves)
            $characterLocations = array_values(array_unique($characterLocations));

            array_push($results, [
                "name" => $jsonEpisode["name"],
                "episode" => $jsonEpisode["episode"],
                "cantLocations" => sizeof($characterLocations),
                "locations" => $characterLocations,
            ]);
        }
        
        return $results;
    }
}