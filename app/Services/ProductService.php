<?php

namespace App\Services;

use App\Repositories\Interface\ProductRepositoryInterface;

class ProductService
{
    public function __construct(protected ProductRepositoryInterface $productRepository)
    {

    }

    public function all()
    {
        return $this->productRepository->all();
    }
}
