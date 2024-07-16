<?php

namespace App\Http\Controllers;

use App\Services\CrawlerService;

class CrawlerController extends Controller
{
    public function __construct(protected CrawlerService $crawlerService) {}

    public function index()
    {
        $this->crawlerService->getAntamPriceList('https://www.logammulia.com/id/harga-emas-hari-ini');

        return true;
    }
}
