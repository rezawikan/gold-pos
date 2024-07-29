<?php

namespace App\Services;

use App\Repositories\Interface\OrderRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;

class OrderService
{
    /**
     * Constructs a new instance of the class.
     *
     * @param  OrderRepositoryInterface  $orderRepository
     */
    public function __construct(protected OrderRepositoryInterface $orderRepository) {}

    /**
     * Get all orders
     *
     * @param  string  $searchText
     * @param  array  $sortBy
     * @param  bool  $isPaginated
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator|\Illuminate\Database\Eloquent\Collection
     */
    public function all(string $searchText = '', array $sortBy = [], bool $isPaginated = false): LengthAwarePaginator|Collection
    {
        return $this->orderRepository->all($searchText, $sortBy, $isPaginated);
    }
}
