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

}