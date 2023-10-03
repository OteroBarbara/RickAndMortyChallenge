<?php

namespace App\Service;

/**
 * CacheService proporciona funcionalidad de almacenamiento en caché para guardar y recuperar datos.
 */
class CacheService
{
    /**
     * Recupera datos de la caché o los obtiene mediante una función CallBack si no están.
     *
     * @param string   $cacheFile               La ruta al archivo de caché.
     * @param int      $cacheDurationInSeconds La duración en segundos durante la cual la caché se considera válida.
     * @param callable $dataCallback           Una función CallBack que obtiene los datos si no se encuentran en la caché.
     *
     * @return array Los datos en caché o los datos obtenidos mediante la función de devolución de llamada.
     *
     * @throws \Exception Cuando ocurre un error durante las operaciones de archivos.
     */
    public function get($cacheFile, $cacheDurationInSeconds, $dataCallback): array
    {
        if (file_exists($cacheFile) && (time() - filemtime($cacheFile)) < $cacheDurationInSeconds) {
            // Si el archivo de caché existe y no ha expirado, devolver los datos en caché
            return json_decode(file_get_contents($cacheFile), true);
        } else {
            // Obtener los datos utilizando la función de callback proporcionada
            $data = $dataCallback();

            // Almacenar los datos en caché en un archivo
            file_put_contents($cacheFile, json_encode($data));

            return $data;
        }
    }
}
