<?php

namespace App\Services;

use App\Models\Product;
use App\Repositories\Interface\ProductRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

class ProductService
{
    /**
     * Constructs a new instance of the class.
     *
     * @param  ProductRepositoryInterface  $productRepository  The product repository interface.
     */
    public function __construct(protected ProductRepositoryInterface $productRepository) {}

    /**
     * Retrieve all products.
     *
     * @return Collection
     */
    public function all(): Collection
    {
        return $this->productRepository->all();
    }

    /**
     * @param  int  $id
     * @param  int  $basePrice
     * @param  int  $stock
     * @return \App\Models\Product|null
     */
    public function addStock(int $id, int $basePrice, int $stock): ?Product
    {
        return $this->productRepository->addStock($id, $basePrice, $stock);
    }

    /**
     * @param  int  $id
     * @param  int  $productItemId
     * @param  int  $basePrice
     * @param  int  $stock
     * @return int
     */
    public function updateStock(int $id, int $productItemId, int $basePrice, int $stock): int
    {
        return $this->productRepository->updateStock($id, $productItemId, $basePrice, $stock);
    }
}
