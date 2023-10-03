<?php

namespace App\Service;

/**
 * El servicio CharCounterService proporciona métodos para contar las ocurrencias de un carácter.
 */
class CharCounterService
{
    /**
     * Cuenta las ocurrencias de un carácter en los valores de un atributo de una lista de objetos.
     *
     * @param array $elementsList Lista de objetos a procesar.
     * @param string $attribute Nombre del atributo en el que se quiere buscar el caracter.
     * @param string $char Caracter a buscar (insensible a mayúsculas y minúsculas).
     * @return int Cantidad de ocurrencias del caracter.
     */
    public function getCount(array $elementsList, string $attribute, string $char): int
    {
        // Inicializar contador
        $count = 0;

        // Nos aseguramos del caracter esté en minúscula
        $char = mb_strtolower($char);

        // Recorrer la lista
        foreach ($elementsList as $element) {
            // Verificar si el atributo existe
            if (isset($element[$attribute])) {
                // Obtener el valor
                $attributeValue = $element[$attribute];

                // Lo pasamos a minúscula
                $attributeValue = mb_strtolower($attributeValue);

                // Contar las ocurrencias del char en el valor del atributo
                $count += mb_substr_count($attributeValue, $char);
            }
        }

        return $count;
    }

    /**
     * Obtiene un resumen de las ocurrencias de un caracter según lo solicitado:
     * - cuántas veces aparece la letra "l" (case insensitive) en los nombres de todos los "location"
     * - cuántas veces aparece la letra "e" (case insensitive) en los nombres de todos los "episode"
     * - cuántas veces aparece la letra "c" (case insensitive) en los nombres de todos los "character"
     *
     * @param array $locationsList Lista de todos los "location".
     * @param array $episodesList Lista de todos los "episode".
     * @param array $charactersList Lista de todos los "character".
     * @return array Arreglo con la información de las ocurrencias (en el atributo nombre)
     * de los caracteres "l" en los "location", "e" en los "episode" y "c" en los "character".
     */
    public function getExerciseOne(array $locationsList, array $episodesList, array $charactersList) : array
    {
        return [
            [
                "char" => "l",
                "count" => $this->getCount($locationsList, "name", 'l'),
                "resource" => "location",
            ],
            [
                "char" => "e",
                "count" => $this->getCount($episodesList, "name", 'e'),
                "resource" => "episode",
            ],
            [
                "char" => "c",
                "count" => $this->getCount($charactersList, "name", 'c'),
                "resource" => "character",
            ],
        ];
    }
}
