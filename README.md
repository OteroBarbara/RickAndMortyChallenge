# RickAndMortyChallenge

## Consigna:

Tienes que consultar todos los `character`, `locations` y `episodes` de https://rickandmortyapi.com/ e indicar:

### Char counter:

  - Cuántas veces aparece la letra **"l"** (case insensitive) en los nombres de todos los `location`

  - Cuántas veces aparece la letra **"e"** (case insensitive) en los nombres de todos los `episode`

  - Cuántas veces aparece la letra **"c"** (case insensitive) en los nombres de todos los `character`

  - Cuánto tardó el programa 👆 en total (desde inicio ejecución hasta entrega de resultados)

### Episode locations:

  - Para cada `episode`, indicar la cantidad y un listado con las `location` (`origin`) de todos los `character` que aparecieron en ese `episode` (sin repetir)

  - Cuánto tardó el programa 👆 en total (desde inicio ejecución hasta entrega de resultados)

### Output:

  En formato `json` con esta estructura:

  ```json
  [
  {
      "exercise_name": "Char counter",
      "time": "2s 545.573272ms",
      "in_time": true,
      "results": [
          {
              "char": "l",
              "count": 12345,
              "resource": "location"
          },
          {
              "char": "e",
              "count": 12345,
              "resource": "episode"
          },
          {
              "char": "c",
              "count": 12345,
              "resource": "character"
          }
      ]
  },
  {
      "exercise_name": "Episode locations",
      "time": "1s 721.975698ms",
      "in_time": true,
      "cant_locations": 3,
      "results": [
          {
              "name": "Pickle Rick",
              "episode": "S03E03",
              "locations": [
                "Earth (C-137)",
                "Earth (Replacement Dimension)",
                "unknown"
              ]
          }
      ]
  }
]
```
## Solución

El proyecto consta de las siguientes clases y servicios:

### `CharCounterService`

El servicio `CharCounterService` proporciona métodos para contar las ocurrencias de un carácter. Es el servicio que nos provee de una solución para el primer ejercicio planteado en el challenge.

#### Métodos

- `getCount(array $elementsList, string $attribute, string $char): int`: Cuenta las ocurrencias de un carácter dado un atributo, un caracter y una lista de elementos.

- `getExerciseOne(array $locationsList, array $episodesList, array $charactersList): array`: Realiza el primer ejercicio del challenge que consiste contar la cantidad de "l" en los nombres de los "location", las "c" en los nombres de los "character" y las "e" en los nombres de los "episode".

### `EpisodeLocationService`

El servicio `EpisodeLocationService` ofrece métodos para obtener información sobre las locaciones de origen de personajes en episodios. Este es el servicio que provee una solución para el segundo ejercicio del challenge.

#### Métodos

- `getEpisodesLocations(array $episodesList, array $charactersList): array`: Dada una lista de episodios y de personajes, obtiene la siguiente información de cada episodio: nombre, episodio, cantidad y listado de locaciones de origen de sus personajes.

### `TimeFormatter`

La clase `TimeFormatter` proporciona un método para formatear milisegundos en segundos y milisegundos.

#### Métodos

- `millisecondsToTimeString(int $milliseconds): string`: Convierte milisegundos a segundos y milisegundos.

## Instalación

Para utilizar este proyecto, sigue estos pasos:

1. Clona el repositorio en tu máquina local:

   `git clone https://github.com/tu-usuario/rick-and-morty-api-challenge.git`

## Testeo

Para testear los servicios de la aplicación, sigue estos pasos:

1. Abrir la terminal en el directorio raiz del proyecto y ejecutar el siguiente comando:

    `php bin/phpunit`