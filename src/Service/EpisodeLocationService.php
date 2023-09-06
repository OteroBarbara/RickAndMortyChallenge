<?php

namespace App\Service;

/**
 * El servicio EpisodeLocationService proporciona métodos para obtener información sobre las locaciones de origen de los personajes en una lista de episodios.
 */
class EpisodeLocationService
{
    /**
     * Obtiene la información de las locaciones de origen de los personajes de una lista de episodios.
     *
     * @param array $episodesList Lista de episodios.
     * @param array $charactersList Lista de personajes.
     * @return array Arreglo con información de cada episodio: nombre, episodio, cantidad y listado de locaciones de origen de sus personajes.
     */
    public function getEpisodesLocations(array $episodesList, array $charactersList): array
    {
        $results = [];
        // Recorrer la lista    
        foreach ($episodesList as $episode) {

            // Obtener los personajes del episodio
            $charactersUrls = $episode["characters"];
            $characterLocations = $this->getCharactersLocations($charactersUrls,$charactersList);

            // Formato de la respuesta
            array_push($results, [
                "name" => $episode["name"],
                "episode" => $episode["episode"],
                "cant_locations" => sizeof($characterLocations),
                "locations" => $characterLocations,
            ]);
        }
        
        return $results;
    }

    /**
     * Obtiene las locaciones de origen de los personajes a partir de sus URLs.
     *
     * @param array $charactersUrlsList Lista de URLs de personajes.
     * @param array $charactersList Lista de personajes.
     * @return array Arreglo de locaciones de origen de los personajes.
     */
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