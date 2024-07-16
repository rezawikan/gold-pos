<?php

namespace App\Services;

use App\Observers\AntamPriceCrawlerObserver;
use GuzzleHttp\RequestOptions;
use Spatie\Crawler\Crawler;
use Spatie\Crawler\CrawlProfiles\CrawlInternalUrls;

class CrawlerService
{
    /**
     * Get the Antam price list from the specified URL.
     *
     * @param  string  $url  The URL to crawl for Antam price list
     * @return void
     */
    public function getAntamPriceList(string $url): void
    {
        // Create a new crawler instance
        Crawler::create([
            RequestOptions::ALLOW_REDIRECTS => true,
            RequestOptions::TIMEOUT => 60,
        ])
            // Configure the crawler to accept nofollow links
            ->acceptNofollowLinks()
            // Configure the crawler to ignore robots.txt files
            ->ignoreRobots()
            // Set the crawl observer to AntamPriceCrawlerObserver
            ->setCrawlObserver(new AntamPriceCrawlerObserver)
            // Set the crawl profile to CrawlInternalUrls
            ->setCrawlProfile(new CrawlInternalUrls($url))
            // Set the maximum response size to 2 MB
            ->setMaximumResponseSize(1024 * 1024 * 2)
            // Set the total crawl limit to 100
            ->setTotalCrawlLimit(100)
            // Set the concurrency to 1 (crawl URLs one by one)
            ->setConcurrency(1)
            // Set the delay between requests to 100 milliseconds
            ->setDelayBetweenRequests(100)
            // Start crawling the specified URL
            ->startCrawling($url);
    }

    /**
     * Get the Antam buyback price from the specified URL.
     *
     * @param  string  $url  The URL to crawl for Antam buyback price
     * @return void
     */
    public function getAntamBuybackPrice(string $url): void
    {
        // Create a new Crawler instance with the specified options
        Crawler::create([
            RequestOptions::ALLOW_REDIRECTS => true,
            RequestOptions::TIMEOUT => 60,
        ])
            // Accept nofollow links
            ->acceptNofollowLinks()
            // Ignore robots.txt
            ->ignoreRobots()
            // Set the crawl observer to AntamPriceCrawlerObserver
            ->setCrawlObserver(new AntamPriceCrawlerObserver)
            // Set the crawl profile to CrawlInternalUrls with the specified URL
            ->setCrawlProfile(new CrawlInternalUrls($url))
            // Set the maximum response size to 2 MB
            ->setMaximumResponseSize(1024 * 1024 * 2)
            // Set the total crawl limit to 100
            ->setTotalCrawlLimit(100)
            // Set the concurrency to 1
            ->setConcurrency(1)
            // Set the delay between requests to 100
            ->setDelayBetweenRequests(100)
            // Start crawling with the specified URL
            ->startCrawling($url);
    }
}
