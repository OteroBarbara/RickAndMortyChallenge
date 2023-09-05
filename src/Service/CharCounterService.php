<?php

namespace App\Service;

class CharCounterService
{
    public function getCount(array $jsonList, string $attribute, string $char): int
    {
        // Inicializar contador
        $count = 0;

        // Recorrer la lista
        foreach ($jsonList as $jsonObject) {

            // Verificar si el atributo existe
            if (isset($jsonObject[$attribute])) {

                // Obtener el valor
                $attributeValue = $jsonObject[$attribute];

                // Contar las ocurrencias del char en el valor del atributo
                $count += mb_substr_count($attributeValue, $char);
            }
        }

        return $count;
    }

    public function getExerciseOne(array $locationsList, array $episodesList, array $charactersList) : array {
        return [
            [
                "char" => "l",
                "count" => $this->getCount($locationsList,"name",'l'),
                "resource" => "location",
            ],
            [
                "char" => "e",
                "count" => $this->getCount($episodesList,"name",'e'),
                "resource" => "episode",
            ],
            [
                "char" => "c",
                "count" => $this->getCount($charactersList,"name",'c'),
                "resource" => "character",
            ],
        ];
    }

}