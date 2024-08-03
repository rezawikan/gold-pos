<?php

namespace App\Repositories\Interface;

use App\Models\Customer;
use App\Models\CustomerCart;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

interface CustomerRepositoryInterface
{
    public function all(string $searchText = '', array $sortBy = [], bool $isPaginated = false): LengthAwarePaginator|Collection;

    public function find(?int $id): ?Customer;

    public function getCarts(int $customerId): array;

    public function updateQuantity(Customer $customer, int $productId, int $quantity): void;

    public function getCart(int $customerId, int $productId): ?CustomerCart;

    public function deleteCart(int $customerId, int $productId): void;
}
