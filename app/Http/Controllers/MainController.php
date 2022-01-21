<?php

namespace App\Http\Controllers;


use App\DTO\ParserConfigDTO;
use App\Services\ParserService;

class MainController extends Controller
{
    public function parserNews(ParserService $parserService)
    {
        $parserConfig = (new ParserConfigDTO())
            ->setUrlSite('https://www.rbc.ru/')
            ->setLinkRule('.js-news-feed-list a');

        $parserService->parserStart($parserConfig);
    }
}
