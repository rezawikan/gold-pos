<?php

namespace App\Repositories;

use App\Models\Product;
use App\Models\ProductPrice;
use App\Repositories\Interface\ProductRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;

class ProductRepository implements ProductRepositoryInterface
{
    /**
     * Show all products with stock
     *
     * @param  string  $searchText
     * @param  array  $sortBy
     * @param  bool  $isPaginated
     * @param  bool  $isReadyForSale
     * @return \Illuminate\Pagination\LengthAwarePaginator|\Illuminate\Database\Eloquent\Collection : Collection
     */
    public function all(string $searchText = '', array $sortBy = [], bool $isPaginated = false, bool $isReadyForSale = false): LengthAwarePaginator|Collection
    {
        $products = Product::leftJoin('product_prices AS current_record', function ($join) {
            $join->on('products.id', '=', 'current_record.product_id')
                ->whereDate('current_record.date', '=', DB::raw('CURDATE()'));
        })->leftJoin('product_prices AS latest_record', function ($join) {
            $join->on('products.id', '=', 'latest_record.product_id')
                ->where('latest_record.date', '=', function ($query) {
                    $query->select(DB::raw('MAX(date)'))
                        ->from('product_prices')
                        ->whereColumn('product_id', 'latest_record.product_id')
                        ->latest('latest_record.date');
                });
        })->leftJoin('product_items AS PI', 'products.id', '=', 'PI.product_id')
            ->leftJoin('brands AS BA', 'products.brand_id', '=', 'BA.id')
            ->leftJoin('types AS TP', 'products.type_id', '=', 'TP.id')
            ->where('products.name', 'like', '%'.$searchText.'%')
            ->groupBy('products.id', 'products.name', 'products.additional_sell_price', 'products.additional_buy_price', 'products.grams')
            ->orderBy(...array_values($sortBy))
            ->selectRaw("
                products.id,
                products.name,
                BA.name AS product_brand,
                TP.name AS product_type,
                products.grams,
                COALESCE(MAX(current_record.sell_price), MAX(latest_record.sell_price)) AS sell_price,
                COALESCE(MAX(current_record.buy_price), MAX(latest_record.buy_price)) AS buy_price,
                COALESCE(MAX(current_record.date), MAX(latest_record.date)) AS price_updated_at,
                COALESCE(SUM(CASE WHEN PI.based_price <= COALESCE(current_record.sell_price, latest_record.sell_price, 0) OR NOT '$isReadyForSale' THEN PI.stock ELSE 0 END), 0) AS stock,
                products.updated_at,
                products.created_at
            ")
            ->withCasts([
                'price_updated_at' => 'datetime',
                'created_at' => 'datetime',
                'updated_at' => 'datetime',
            ]);

        if ($isPaginated) {
            return $products->paginate(10);
        }

        return $products->get();
    }

    /**
     * Get available stock
     *
     * @param  int  $productId
     * @return int
     */
    public function getAvailableStock(int $productId): int
    {
        // Get the latest sell price directly
        $latestSellPrice = ProductPrice::where('product_id', $productId)
            ->latest('date')
            ->value('sell_price');

        // Join product_items and calculate stock
        $stock = Product::leftJoin('product_items AS PI', function ($join) use ($latestSellPrice) {
            $join->on('products.id', '=', 'PI.product_id')
                ->where('PI.based_price', '<=', $latestSellPrice);
        })
            ->where('products.id', $productId)
            ->selectRaw('COALESCE(SUM(PI.stock), 0) AS stock')
            ->first();

        return $stock->stock;
    }

    /**
     * Find a product by ID.
     *
     * @param  string  $id
     * @return \App\Models\Product
     */
    public function find(string $id): Product
    {
        return Product::find($id);
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
