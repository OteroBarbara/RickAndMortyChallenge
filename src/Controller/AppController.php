<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use App\Api\RickAndMortyApiService;
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
    public function index(CharCounterService $charCounter): JsonResponse
    {
        $stopwatch = new Stopwatch();
        $stopwatch->start('char_count');

        $locationData = $this->rickAndMortyApiService->getLocations()['results'];
        $episodeData = $this->rickAndMortyApiService->getEpisodes()['results'];
        $charactersData = $this->rickAndMortyApiService->getCharacters()['results'];

        $results = [
            [
                "char" => "l",
                "count" => $charCounter->getCount($locationData,"name",'l'),
                "resource" => "location",
            ],
            [
                "char" => "e",
                "count" => $charCounter->getCount($episodeData,"name",'e'),
                "resource" => "episode",
            ],
            [
                "char" => "c",
                "count" => $charCounter->getCount($charactersData,"name",'c'),
                "resource" => "character",
            ],
        ];        

        $event = $stopwatch->stop('char_count');
        $executionTime = $event->getDuration();
        $formattedTime = TimeFormatter::millisecondsToTimeString($executionTime);

        return new JsonResponse([
            "exercise_name" => "Char counter",
            "time" => $formattedTime,
            "in_time" => $executionTime < 3000,
            "results" => $results
        ]);
    }
}
