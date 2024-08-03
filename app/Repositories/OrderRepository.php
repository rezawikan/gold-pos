<?php

namespace App\Repositories;

use App\Models\Order;
use App\Repositories\Interface\OrderRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;

class OrderRepository implements OrderRepositoryInterface
{
    /**
     * Show all orders
     *
     * @param  string  $searchText
     * @param  array  $sortBy
     * @param  bool  $isPaginated
     * @return LengthAwarePaginator|\Illuminate\Database\Eloquent\Collection
     */
    public function all(string $searchText = '', array $sortBy = [], bool $isPaginated = false): LengthAwarePaginator|Collection
    {
        $orders = Order::with(['customer'])->where('id', 'like', '%'.$searchText.'%')
            ->orderBy(...array_values($sortBy));

        if ($isPaginated) {
            return $orders->paginate(10);
        }

        return $orders->get();
    }

    /**
     * Find order by id
     *
     * @param  int|null  $id
     * @return Order|null
     */
    public function find(?int $id): ?Order
    {
        return new Order;
    }
}
