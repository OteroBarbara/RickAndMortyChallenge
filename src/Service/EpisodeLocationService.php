<?php

namespace App\Service;

class EpisodeLocationService
{
    public function getEpisodesLocations(array $episodesList, array $charactersList): array
    {
        $results = [];
        // Recorrer la lista    
        foreach ($episodesList as $jsonEpisode) {

            // Obtener los personajes del episodio
            $charactersUrls = $jsonEpisode["characters"];
            $characterLocations = $this->getCharactersLocations($charactersUrls,$charactersList);

            // Formato de la respuesta
            array_push($results, [
                "name" => $jsonEpisode["name"],
                "episode" => $jsonEpisode["episode"],
                "cant_locations" => sizeof($characterLocations),
                "locations" => $characterLocations,
            ]);
        }
        
        return $results;
    }

    private function getCharactersLocations(array $charactersUrlsList, array $charactersList): array
    {

        $characterLocations = [];

        foreach ($charactersUrlsList as $url) {
            // Disponemos de la lista de personajes, así que nos quedamos con la parte de la url que representa el ID
            $characterId = basename(strrchr($url, "/"));
            // Con el ID consultamos la locación de origen del personaje en el arreglo que disponemos
            array_push($characterLocations,$charactersList[$characterId-1]["origin"]["name"]);
        }

        // Eliminamos los duplicados y lo convertimos en un arreglo indexado (sin claves)
        $characterLocations = array_values(array_unique($characterLocations));

        return $characterLocations;
    }

}