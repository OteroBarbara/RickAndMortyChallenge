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

    #[Route('/', name: 'home')]
    public function index(CharCounterService $charCounter, EpisodeLocationService $episodeLocation): JsonResponse
    {
        $stopwatch = new Stopwatch();
        $stopwatch->start('char_count');

        $locationsData = $this->rickAndMortyApiService->getLocations();
        $episodesData = $this->rickAndMortyApiService->getEpisodes();
        $charactersData = $this->rickAndMortyApiService->getCharacters();

        $results = [
            [
                "char" => "l",
                "count" => $charCounter->getCount($locationsData,"name",'l'),
                "resource" => "location",
            ],
            [
                "char" => "e",
                "count" => $charCounter->getCount($episodesData,"name",'e'),
                "resource" => "episode",
            ],
            [
                "char" => "c",
                "count" => $charCounter->getCount($charactersData,"name",'c'),
                "resource" => "character",
            ],
        ];        


        $exercise2 = $episodeLocation->getLocations($episodesData,$charactersData);
        
        $event = $stopwatch->stop('char_count');
        $executionTime = $event->getDuration();
        $formattedTime = TimeFormatter::millisecondsToTimeString($executionTime);

        
        return new JsonResponse([
            /* "exercise_name" => "Char counter",
            "time" => $formattedTime,
            "in_time" => $executionTime < 3000,
            "results" => $results, */
            "exercise_name" => "Episode locations",
            "time" => $formattedTime,
            "in_time" => $executionTime < 3000,
            "results" => $exercise2,
        ]);
    }
}
