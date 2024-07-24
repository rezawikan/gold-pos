<?php

namespace App\Repositories;

use App\Models\Customer;
use App\Repositories\Interface\CustomerRepositoryInterface;
use Illuminate\Pagination\LengthAwarePaginator;

class CustomerRepository implements CustomerRepositoryInterface
{
    /**
     * Show all customers
     *
     * @param  string  $searchText
     * @param  array  $sortBy
     * @return \Illuminate\Pagination\LengthAwarePaginator
     */
    public function all(string $searchText = '', array $sortBy = []): LengthAwarePaginator
    {
        return Customer::where('name', 'like', '%'.$searchText.'%')
            ->orderBy(...array_values($sortBy))
            ->paginate(10);
    }
}
