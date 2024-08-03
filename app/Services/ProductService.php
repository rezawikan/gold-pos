<?php

namespace App\Services;

use App\Models\Product;
use App\Repositories\Interface\ProductRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

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
     * @param  string  $searchText
     * @param  array  $sortBy
     * @param  bool  $isPaginated
     * @param  bool  $isReadyForSale
     * @return LengthAwarePaginator|Collection
     */
    public function all(string $searchText = '', array $sortBy = [], bool $isPaginated = false, bool $isReadyForSale = false): LengthAwarePaginator|Collection
    {
        return $this->productRepository->all($searchText, $sortBy, $isPaginated, $isReadyForSale);
    }

    /**
     * Retrieve a product by id.
     *
     * @param  string  $id
     * @return \App\Models\Product
     */
    public function find(string $id): Product
    {
        return $this->productRepository->find($id);
    }

    /**
     * Get available stock for a product
     *
     * @param  int  $id
     * @return int
     */
    public function getAvailableStock(int $id): int
    {
        return $this->productRepository->getAvailableStock($id);
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
