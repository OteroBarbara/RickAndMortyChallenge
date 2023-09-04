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
