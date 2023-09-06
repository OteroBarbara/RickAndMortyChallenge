<?php

namespace App\Tests\Service;

use App\Service\CharCounterService;
use PHPUnit\Framework\TestCase;

class CharCounterTest extends TestCase
{
    private $locations;
    private $characters;
    private $episodes;
    private $charCounter;

    public function setUp(): void
    {
        parent::setUp();

        // Instancia el servicio
        $this->charCounter = new CharCounterService();

        // Carga los datos de prueba
        $this->locations = [
            [
                "id" => 1,
                "name" => "Earth (C-137)",
                "type" => "Planet",
                "dimension" => "Dimension C-137",
                "residents" => [],
                "url" => "https://rickandmortyapi.com/api/location/1",
                "created" => "2017-11-10T12:42:04.162Z"
            ],
            [
                "id" => 2,
                "name" => "Abadango",
                "type" => "Cluster",
                "dimension" => "unknown",
                "residents" => [],
                "url" => "https://rickandmortyapi.com/api/location/2",
                "created" => "2017-11-10T13:06:38.182Z",
            ]
        ];
        $this->episodes = [
            [
                "id" => 1,
                "name" => "Pilot",
                "air_date" => "December 2, 2013",
                "episode" => "S01E01",
                "characters" => [],
                "url" => "https://rickandmortyapi.com/api/episode/1",
                "created" => "2017-11-10T12:56:33.798Z"
            ],
            [
                "id" => 2,
                "name" => "Lawnmower Dog",
                "air_date" => "December 9, 2013",
                "episode" => "S01E02",
                "characters" => [],
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
                "origin" => [],
                "location" => [],
                "image" => "https://rickandmortyapi.com/api/character/avatar/1.jpeg",
                "episode" => [],
                "url" => "https://rickandmortyapi.com/api/character/1",
                "created" => "2017-11-04T18:48:46.250Z"
            ],
            [
                "id" => 63,
                "name" => "Centaur",
                "status" => "Alive",
                "species" => "Mythological Creature",
                "type" => "Centaur",
                "gender" => "Male",
                "origin" => [],
                "location" => [],
                "image" => "https://rickandmortyapi.com/api/character/avatar/63.jpeg",
                "episode" => [],
                "url" => "https://rickandmortyapi.com/api/character/63",
                "created" => "2017-11-05T12:22:17.848Z"
            ]
        ];
    }

    // Testeamos que el contador de caracteres realiza el conteo correctamente siendo case insensitive
    public function testCharCounter(): void
    {
        $result = $this->charCounter->getCount($this->locations,'name','a');
        $this->assertEquals($result, 4);

        $result = $this->charCounter->getCount($this->locations,'name','A');
        $this->assertEquals($result, 4);
    }

    // Testeamos que si la data está vacía devuelve 0
    public function testCharCounterEmtyArray(): void
    {
        $array = [];
        $resultado = $this->charCounter->getCount($array,'name','a');

        $this->assertEquals($resultado, 0);
    }

    // Testeamos que se cumpla el formato esperado para el ejercicio 1
    public function testExerciseOne(): void
    {
        $expectedArray = [
            [
                "char" => "l",
                "count" => 0,
                "resource" => "location",
            ],
            [
                "char" => "e",
                "count" => 1,
                "resource" => "episode",
            ],
            [
                "char" => "c",
                "count" => 3,
                "resource" => "character",
            ],
        ];

        $result = $this->charCounter->getExerciseOne($this->locations,$this->episodes,$this->characters);

        $this->assertEquals($expectedArray, $result);
    }

}
