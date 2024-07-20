<?php

namespace App\Http\Controllers;

use App\Services\CrawlerService;

class CrawlerController extends Controller
{
    public function __construct(protected CrawlerService $crawlerService) {}

    public function index()
    {
        $crawlerService = $this->crawlerService;
        $crawlerService->getAntamPriceList();
//        dd('ok');
        return view('welcome');
    }
}
