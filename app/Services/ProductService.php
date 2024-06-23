<?php

namespace App\Services;

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
}
