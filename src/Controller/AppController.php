<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use App\Api\RickAndMortyApiService;
use App\Service\EpisodeLocationService;
use App\Service\CharCounterService;
use Symfony\Component\Stopwatch\Stopwatch;
use App\Utils\TimeFormatter;

class AppController extends AbstractController
{
    private $rickAndMortyApiService;

    public function __construct(RickAndMortyApiService $rickAndMortyApiService)
    {
        $this->rickAndMortyApiService = $rickAndMortyApiService;
    }

    #[Route('/', name: 'results')]
    public function index(CharCounterService $charCounter, EpisodeLocationService $episodeLocation): JsonResponse
    {
        $stopwatch = new Stopwatch();
        $stopwatch->start('cronometro');

        $locationsData = $this->rickAndMortyApiService->getLocations();
        $episodesData = $this->rickAndMortyApiService->getEpisodes();
        $charactersData = $this->rickAndMortyApiService->getCharacters();

        dump($charactersData);die();

        $resultsExercise1 = $charCounter->getExerciseOne($locationsData,$episodesData,$charactersData);

        $event = $stopwatch->lap('cronometro');
        $executionTime = $event->getDuration();

        $exercise1 = [
            "exercise_name" => "Char counter",
            "time" => TimeFormatter::millisecondsToTimeString($executionTime),
            "in_time" => $executionTime < 3000,
            "results" => $resultsExercise1,
        ];

        $resultsExercise2 =  $episodeLocation->getEpisodesLocations($episodesData,$charactersData);
        
        $event = $stopwatch->stop('cronometro');
        $executionTime = $event->getDuration();
             
        $exercise2 = [
            "exercise_name" => "Episode locations",
            "time" => TimeFormatter::millisecondsToTimeString($executionTime),
            "in_time" => $executionTime < 3000,
            "results" => $resultsExercise2,
        ];
        
        return new JsonResponse([$exercise1,$exercise2]);
    }
}
