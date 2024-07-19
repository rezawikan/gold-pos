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
//            dd('asd');
            throw new ProcessFailedException($process);
        }


        $asd = $process->getOutput();
        dd($asd);
//        $process = new Process(['node', 'resources/js/AntamSellCrawler.js']);
//        $asd
//        dd($process);
//        $process->run();
//        if (! $process->isSuccessful()) {
//            throw new ProcessFailedException($process);
//        }
//
//        $output = $process->getOutput();
//        $errors = $process->getErrorOutput();
//        //        $this->crawlerService->getAntamPriceList('https://www.logammulia.com/id/harga-emas-hari-ini');

//        return true;
    }
}
