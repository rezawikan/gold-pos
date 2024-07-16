<?php

namespace App\Observers;

use DOMDocument;
use GuzzleHttp\Exception\RequestException;
use Illuminate\Support\Facades\Log;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\UriInterface;
use Spatie\Crawler\CrawlObservers\CrawlObserver;

class AntamBuybackPriceCrawlerObserver extends CrawlObserver
{
    private array $content;

    public function __construct()
    {
        $this->content = [];
    }

    /*
 * Called when the crawler will crawl the url.
 */
    public function willCrawl(UriInterface $url, ?string $linkText): void
    {
        Log::info('willCrawl', ['url' => $url]);
    }

    /*
     * Called when the crawler has crawled the given url successfully.
     */
    public function crawled(
        UriInterface      $url,
        ResponseInterface $response,
        ?UriInterface     $foundOnUrl = null,
        ?string           $linkText = null,
    ): void
    {
        $doc = new DOMDocument;
        @$doc->loadHTML($response->getBody());
        //# save HTML
        $content = $doc->saveHTML();

        $field_names = ['berat', 'harga_dasar', 'harga_pajak'];
        $result = [];

        // will be changed later
        foreach ($doc->getElementsByTagName('tr') as $key => $tr) {
            $i = 0;
            $row = [];
            $cells = $tr->getElementsByTagName('td');
            if ($key === 10) {
                break;
            }
            if ($key > 1) {
                // Collect the first count($field_names) cell values as maximum
                foreach ($field_names as $name) {
                    if (!$td = $cells->item($i++)) {
                        break;
                    }
                    $row[$name] = trim($td->textContent);
                }

                if ($row) {
                    $result[] = $row;
                }
            }

        }

        $this->content = $result;
    }

    /*
     * Called when the crawler had a problem crawling the given url.
     */
    public function crawlFailed(
        UriInterface     $url,
        RequestException $requestException,
        ?UriInterface    $foundOnUrl = null,
        ?string          $linkText = null,
    ): void
    {
        Log::error('crawlFailed', ['url' => $url, 'error' => $requestException->getMessage()]);
    }

    /**
     * Called when the crawl has ended.
     */
    public function finishedCrawling(): void
    {
        Log::info('finishedCrawling');
        //# store $this->content in DB
        //# Add logic here

        Log::info('resultCrawling', ['content' => $this->content]);
    }
}
