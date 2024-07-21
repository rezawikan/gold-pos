<?php

namespace App\Services;

use App\Models\Product;
use Symfony\Component\Process\Exception\ProcessFailedException;
use Symfony\Component\Process\Process;

class CrawlerService
{
    /**
     * Get the Antam price list from the specified URL.
     *
     * @return void
     */
    public function getAntamPriceList(): void
    {
        $process = new Process(['node', '../resources/puppeteer/AntamSellCrawler.js']);
        $process->run();

        // executes after the command finishes
        if (! $process->isSuccessful()) {
            throw new ProcessFailedException($process);
        }
        $decodedResult = collect(
            json_decode(
                stripslashes(
                    $process->getOutput()
                ), true)
        );

        $this->updateProductPriceBars($decodedResult['batangan']['data']);
    }

    protected function updateProductPriceBars(array $data): void
    {
        foreach ($data as $value) {
            $product = Product::where('grams', $value['grams'])
                ->where('brand_id', 1)
                ->where('type_id', 1)
                ->first();

            $currentProductPrice = $product->product_prices()->whereRaw('Date(date) = CURDATE()');
            if ($currentProductPrice->exists()) {
                $currentProductPrice->first()->update([
                    'price' => (int) $value['price'] + (int) $product->additional_price,
                    'date' => now(),
                ]);
            } else {
                $product->product_prices()
                    ->create([
                        'price' => (int) $value['price'] + (int) $product->additional_price,
                        'date' => now(),
                    ]);
            }
        }
    }
}
