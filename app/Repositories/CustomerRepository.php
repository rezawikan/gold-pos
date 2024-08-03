<?php

namespace App\Repositories;

use App\Models\Customer;
use App\Repositories\Interface\CustomerRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

class CustomerRepository implements CustomerRepositoryInterface
{
    /**
     * Show all customers
     *
     * @param  string  $searchText
     * @param  array  $sortBy
     * @param  bool  $isPaginated
     * @return LengthAwarePaginator|Collection
     */
    public function all(string $searchText = '', array $sortBy = [], bool $isPaginated = false): LengthAwarePaginator|Collection
    {
        $customer = Customer::where('name', 'like', '%'.$searchText.'%')
            ->orderBy(...array_values($sortBy));

        if ($isPaginated) {
            return $customer->paginate(10);
        }

        return $customer->get();
    }

    /**
     * Find a customer by id
     *
     * @param  int|null  $id
     * @return Customer|null
     */
    public function find(?int $id): ?Customer
    {
        if (! $id) {
            return null;
        }

        return Customer::find($id);
    }
}
