<?php

namespace App\Utils;

/**
 * La clase TimeFormatter proporciona métodos para formatear valores de tiempo.
 */
class TimeFormatter
{
    /**
     * Convierte milisegundos en un string con el tiempo en segundos y milisegundos.
     *
     * @param int $milliseconds Milisegundos a convertir.
     * @return string Tiempo en segundos y milisegundos.
     */
    public static function millisecondsToTimeString(int $milliseconds): string
    {
        // Convierte milisegundos en segundos
        $seconds = floor($milliseconds / 1000);

        // Obtiene los milisegundos restantes
        $milliseconds = $milliseconds % 1000;

        // Formatea a un string con el tiempo en segundos y milisegundos.
        return sprintf('%ds %.6fms', $seconds, $milliseconds);
    }
}
