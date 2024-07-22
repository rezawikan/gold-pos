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
        $process = new Process(['node', '../resources/puppeteer/AntamCrawler.js']);
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

        $this->updatePrice($decodedResult['batangan']['data'], $decodedResult['buyback_price'], 1, 1);
    }

    protected function updatePrice(array $data, int $buybackPrice, int $brandId, int $typeId): void
    {
        foreach ($data as $value) {
            $product = Product::where('grams', $value['grams'])
                ->where('brand_id', $brandId)
                ->where('type_id', $typeId)
                ->first();

            $currentProductPrice = $product->product_prices()->whereRaw('Date(date) = CURDATE()');
            if ($currentProductPrice->exists()) {
                $currentProductPrice->first()->update([
                    'sell_price' => (int) $value['price'] + $product->additional_sell_price,
                    'buy_price' => ($buybackPrice * $product->grams) + ($product->additional_buy_price * $product->grams),
                    'date' => now(),
                ]);
            } else {
                $product->product_prices()
                    ->create([
                        'sell_price' => (int) $value['price'] + $product->additional_sell_price,
                        'buy_price' => ($buybackPrice * $product->grams) + ($product->additional_buy_price * $product->grams),
                        'date' => now(),
                    ]);
            }
        }
    }
}
