<?php

namespace App\Tests\Service;

use App\Service\EpisodeLocationService;
use PHPUnit\Framework\TestCase;

/**
 * Clase que contiene pruebas para el servicio EpisodeLocationService.
 */
class EpisodeLocationTest extends TestCase
{
    /**
     * @var EpisodeLocationService Instancia del servicio EpisodeLocationService para pruebas.
     */
    private $episodeLocationService;

    /**
     * @var array Arreglo de datos de personajes para pruebas.
     */

    private $characters;

    /**
     * @var array Arreglo de datos de episodios para pruebas.
     */
    private $episodes;

    /**
     * Configura el entorno de prueba antes de cada caso de prueba.
     */
    public function setUp(): void
    {
        parent::setUp();

        // Instancia el servicio
        $this->episodeLocationService = new EpisodeLocationService();

        // Carga los datos de prueba
        $this->episodes = [
            [
                "id" => 1,
                "name" => "Pilot",
                "air_date" => "December 2, 2013",
                "episode" => "S01E01",
                "characters" => [
                    "https://rickandmortyapi.com/api/character/1",
                    "https://rickandmortyapi.com/api/character/2"
                ],
                "url" => "https://rickandmortyapi.com/api/episode/1",
                "created" => "2017-11-10T12:56:33.798Z"
            ],
            [
                "id" => 2,
                "name" => "Lawnmower Dog",
                "air_date" => "December 9, 2013",
                "episode" => "S01E02",
                "characters" => [
                    "https://rickandmortyapi.com/api/character/1",
                    "https://rickandmortyapi.com/api/character/2",
                    "https://rickandmortyapi.com/api/character/3"
                ],
                "url" => "https://rickandmortyapi.com/api/episode/2",
                "created" => "2017-11-10T12:56:33.916Z"
            ]
        ];
        $this->characters = [
            [
                "id" => 1,
                "name" => "Rick Sanchez",
                "status" => "Alive",
                "species" => "Human",
                "type" => "",
                "gender" => "Male",
                "origin" => [
                    "name" => "Earth (C-137)",
                    "url" => "https://rickandmortyapi.com/api/location/1"
                ],
                "location" => [],
                "image" => "https://rickandmortyapi.com/api/character/avatar/1.jpeg",
                "episode" => [],
                "url" => "https://rickandmortyapi.com/api/character/1",
                "created" => "2017-11-04T18:48:46.250Z"
            ],
            [
                "id" => 2,
                "name" => "Morty Smith",
                "status" => "Alive",
                "species" => "Human",
                "type" => "",
                "gender" => "Male",
                "origin" => [
                    "name" => "unknown",
                    "url" => ""
                ],
                "location" => [],
                "image" => "https://rickandmortyapi.com/api/character/avatar/2.jpeg",
                "episode" => [],
                "url" => "https://rickandmortyapi.com/api/character/2",
                "created" => "2017-11-04T18:50:21.651Z"
            ],
            [
                "id" => 3,
                "name" => "Centaur",
                "status" => "Alive",
                "species" => "Mythological Creature",
                "type" => "Centaur",
                "gender" => "Male",
                "origin" => [
                    "name" => "unknown",
                    "url" => ""
                ],
                "location" => [],
                "image" => "https://rickandmortyapi.com/api/character/avatar/63.jpeg",
                "episode" => [],
                "url" => "https://rickandmortyapi.com/api/character/63",
                "created" => "2017-11-05T12:22:17.848Z"
            ]
        ];
    }

    /**
     * Testea que dada una lista de episodios, el método getEpisodesLocations
     * devuelva el nombre, episodio, cantidad y listado de locaciones de origen de sus personajes.
     */
    public function testEpisodesLocations(): void
    {
        $expectedResults = [
            [
                "name" => "Pilot",
                "episode" => "S01E01",
                "cant_locations" => 2,
                "locations" => ["Earth (C-137)", "unknown"]
            ],
            [
                "name" => "Lawnmower Dog",
                "episode" => "S01E02",
                "cant_locations" => 2,
                "locations" => ["Earth (C-137)", "unknown"]
            ],
        ];
    
        $episodeLocations = $this->episodeLocationService->getEpisodesLocations($this->episodes, $this->characters);
    
        // Verificamos que los resultados son los esperados
        $this->assertEquals($expectedResults, $episodeLocations);
    }
}
