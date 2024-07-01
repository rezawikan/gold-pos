<?php

namespace App\Repositories;

use App\Models\Product;
use App\Repositories\Interface\ProductRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;

class ProductRepository implements ProductRepositoryInterface
{
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
}
