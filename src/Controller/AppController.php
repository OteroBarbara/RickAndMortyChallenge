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

        /* $locations = $this->rickAndMortyApiService->getLocations();
        $episodes = $this->rickAndMortyApiService->getEpisodes();
        $characters = $this->rickAndMortyApiService->getCharacters(); */
        $data = $this->rickAndMortyApiService->getAllData();

        $event = $stopwatch->stop('char_count');
        $executionTime = $event->getDuration();
        $formattedTime = TimeFormatter::millisecondsToTimeString($executionTime);
        dump($formattedTime);
        die();

        $results = [
            /* [
                "char" => "l",
                "count" => $charCounter->getCount($locations,"name",'l'),
                "resource" => "location",
            ],
            [
                "char" => "e",
                "count" => $charCounter->getCount($episodes,"name",'e'),
                "resource" => "episode",
            ],
            [
                "char" => "c",
                "count" => $charCounter->getCount($characters,"name",'c'),
                "resource" => "character",
            ], */
        ];        

        return new JsonResponse([
            "exercise_name" => "Char counter",
            "time" => $formattedTime,
            "in_time" => $executionTime < 3000,
            "results" => $results
        ]);
    }
}
