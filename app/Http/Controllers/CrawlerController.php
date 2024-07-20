<?php

namespace App\Http\Controllers;

use App\Services\CrawlerService;
use Symfony\Component\Process\Exception\ProcessFailedException;
use Symfony\Component\Process\Process;

class CrawlerController extends Controller
{
    public function __construct(protected CrawlerService $crawlerService) {}

    public function index()
    {
        $process = new Process(['node', '../resources/puppeteer/AntamSellCrawler.js']);
        $process->run();

        // executes after the command finishes
        if (!$process->isSuccessful()) {
            throw new ProcessFailedException($process);
        }


        $result = $process->getOutput();

        $decodedResult = json_decode(stripslashes($result),true);

        return $decodedResult;
    }
}
