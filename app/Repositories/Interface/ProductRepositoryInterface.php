<?php

namespace App\Repositories\Interface;

use App\Models\Product;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

interface ProductRepositoryInterface
{
    public function all(string $searchText = '', array $sortBy = [], bool $isPaginated = false, bool $isReadyForSale = false): LengthAwarePaginator|Collection;

    public function find(string $id): Product;

    public function getAvailableStock(int $productId): int;

    public function addStock(int $id, int $basePrice, int $stock): ?Product;

    public function updateStock(int $id, int $productItemId, int $basePrice, int $stock): int;

    public function deleteStock(int $id, int $productItemId): int;

    public function addPrice(int $id, int $price, string $date): int;

    public function updatePrice(int $id, int $productPriceId, int $price, string $date): int;
}
