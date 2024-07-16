<?php

namespace App\Repositories\Interface;

use App\Models\Product;
use Illuminate\Pagination\LengthAwarePaginator;

interface ProductRepositoryInterface
{
    public function all(string $searchText = '', array $sortBy = []): LengthAwarePaginator;

    public function addStock(int $id, int $basePrice, int $stock): ?Product;

    public function updateStock(int $id, int $productItemId, int $basePrice, int $stock): int;

    public function deleteStock(int $id, int $productItemId): int;

    public function addPrice(int $id, int $price, string $date): int;

    public function updatePrice(int $id, int $productPriceId, int $price, string $date): int;
}
