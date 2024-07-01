<?php

namespace App\Repositories;

use App\Models\Product;
use App\Repositories\Interface\ProductRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;

class ProductRepository implements ProductRepositoryInterface
{
    /**
     * Show all products with stock
     *
     * @return Collection
     */
    public function all(): Collection
    {
        return Product::leftJoin('product_prices AS current_record', function ($join) {
            $join->on('products.id', '=', 'current_record.product_id')
                ->whereDate('current_record.date', '=', DB::raw('CURDATE()'));
        })
            ->leftJoin('product_prices AS latest_record', function ($join) {
                $join->on('products.id', '=', 'latest_record.product_id')
                    ->where('latest_record.date', '=', function ($query) {
                        $query->select(DB::raw('MAX(date)'))
                            ->from('product_prices')
                            ->whereColumn('product_id', 'latest_record.product_id')
                            ->where('date', '<', DB::raw('CURDATE()'));
                    });
            })
            ->leftJoin('product_items AS PI', 'products.id', '=', 'PI.product_id')
            ->groupBy('products.id', 'products.name', 'products.additional_price', 'products.grams', 'products.updated_at', 'products.created_at')
            ->orderBy('products.id', 'ASC')
            ->selectRaw('
            products.id,
            products.name,
            products.additional_price,
            products.grams,
            COALESCE(MAX(current_record.price), MAX(latest_record.price)) AS price,
            COALESCE(MAX(current_record.date), MAX(latest_record.date)) AS price_updated_at,
            SUM(PI.stock) AS stock,
            products.updated_at,
            products.created_at
        ')
            ->withCasts([
                'price_updated_at' => 'datetime',
                'created_at' => 'datetime',
                'updated_at' => 'datetime',
            ])
            ->get();
    }

    /**
     * Find a product by ID.
     *
     * @param  int  $id  The product ID.
     * @param  int  $basePrice
     * @param  int  $stock
     * @return Product|null
     */
    public function addStock(int $id, int $basePrice, int $stock): ?Product
    {
        return Product::where('id', $id)
            ->product_items()
            ->create([
                'additional_price' => $basePrice,
                'grams' => $stock,
            ]);
    }

    /**
     * @param  int  $id  The product ID.
     * @param  int  $productItemId  The product item ID.
     * @param  int  $basePrice
     * @param  int  $stock
     * @return int The number of affected rows.
     */
    public function updateStock(int $id, int $productItemId, int $basePrice, int $stock): int
    {
        return Product::where('id', $id)
            ->product_items()
            ->where('id', $productItemId)
            ->update([
                'additional_price' => $basePrice,
                'grams' => $stock,
            ]);
    }

    /**
     * @param  int  $id  The product ID.
     * @param  int  $productItemId  The product item ID.
     * @return int The number of affected rows.
     */
    public function deleteStock(int $id, int $productItemId): int
    {
        return Product::where('id', $id)
            ->product_items()
            ->where('id', $productItemId)
            ->delete();
    }

    /**
     * @param  int  $id  The product ID.
     * @param  int  $price
     * @param  string  $date
     * @return int
     */
    public function addPrice(int $id, int $price, string $date): int
    {
        return Product::where('id', $id)
            ->product_prices()
            ->create([
                'price' => $price,
                'date' => $date,
            ]);
    }

    /**
     * @param  int  $id  The product ID.
     * @param  int  $productPriceId  The product price ID.
     * @param  int  $price
     * @param  string  $date
     * @return int
     */
    public function updatePrice(int $id, int $productPriceId, int $price, string $date): int
    {
        return Product::where('id', $id)
            ->product_prices()
            ->where('id', $productPriceId)
            ->update([
                'price' => $price,
                'date' => $date,
            ]);
    }
}
