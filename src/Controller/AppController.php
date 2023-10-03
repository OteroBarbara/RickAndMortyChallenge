<?php

namespace App\Controller;

use App\Api\RickAndMortyAsyncService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use App\Service\EpisodeLocationService;
use App\Service\CharCounterService;
use Symfony\Component\Stopwatch\Stopwatch;
use App\Utils\TimeFormatter;

/**
 * Controlador principal de la aplicación que gestiona las rutas y proporciona los resultados de los ejercicios del challenge.
 */
class AppController extends AbstractController
{
    /**
     * @var RickAndMortyAsyncService Servicio para interactuar con la Api de Rick and Morty.
     */
    private $rickAndMortyAsyncService;

    /**
     * Constructor de la clase.
     *
     * @param RickAndMortyAsyncService $rickAndMortyAsyncService Servicio para interactuar con la Api de Rick and Morty.
     */
    public function __construct(RickAndMortyAsyncService $rickAndMortyAsyncService)
    {
        $this->rickAndMortyAsyncService = $rickAndMortyAsyncService;
    }

    /**
     * @Route('/', name: 'results')
     * 
     * Controlador que maneja la ruta principal y proporciona resultados para dos ejercicios.
     *
     * @param CharCounterService $charCounter Servicio de contador de caracteres.
     * @param EpisodeLocationService $episodeLocation Servicio de ubicaciones de episodios.
     * @return JsonResponse Respuesta JSON que contiene los resultados de los ejercicios del Challenge.
     */
    #[Route('/', name: 'results')]
    public function index(CharCounterService $charCounter, EpisodeLocationService $episodeLocation): JsonResponse
    {
        // Inicializa el cronómetro para medir el tiempo de ejecución.
        $stopwatch = new Stopwatch();
        $stopwatch->start('cronometro');

        // Obtiene datos de ubicaciones, episodios y personajes desde el servicio RickAndMortyAsync.
        $data = $this->rickAndMortyAsyncService->getAllData();
        $locationsData = $data['locations'];
        $episodesData = $data['episodes'];
        $charactersData = $data['characters'];

        // Ejercicio 1: Conteo de caracteres en nombres de ubicaciones, episodios y personajes.
        $resultsExercise1 = $charCounter->getExerciseOne($locationsData,$episodesData,$charactersData);

        // Registra el tiempo de ejecución al finalizar el primer ejercicio.
        $event = $stopwatch->lap('cronometro');
        $executionTime = $event->getDuration();

        // Formato para los resultados del ejercicio 1.
        $exercise1 = [
            "exercise_name" => "Char counter",
            "time" => TimeFormatter::millisecondsToTimeString($executionTime),
            "in_time" => $executionTime < 3000,
            "results" => $resultsExercise1,
        ];

        // Ejercicio 2: Obtención de locaciones de origen de personajes en episodios.
        $resultsExercise2 =  $episodeLocation->getEpisodesLocations($episodesData,$charactersData);
        
        // Detiene el cronómetro y registra el tiempo de ejecución al terminar el segundo ejercicio.
        $event = $stopwatch->stop('cronometro');
        $executionTime = $event->getDuration();
             
        // Formato para los resultados del ejercicio 2.
        $exercise2 = [
            "exercise_name" => "Episode locations",
            "time" => TimeFormatter::millisecondsToTimeString($executionTime),
            "in_time" => $executionTime < 3000,
            "results" => $resultsExercise2,
        ];
        
        // Devuelve una respuesta JSON que contiene los resultados de ambos ejercicios.
        return new JsonResponse([$exercise1,$exercise2]);
    }
}
