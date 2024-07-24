<?php

namespace App\Services;

use App\Repositories\Interface\CustomerRepositoryInterface;
use Illuminate\Pagination\LengthAwarePaginator;

class CustomerService
{
    /**
     * Constructs a new instance of the class.
     *
     * @param  \App\Repositories\Interface\CustomerRepositoryInterface  $customerRepository
     */
    public function __construct(protected CustomerRepositoryInterface $customerRepository) {}

    /**
     * Retrieve all customers.
     *
     * @param  string  $searchText
     * @param  array  $sortBy
     * @return \Illuminate\Pagination\LengthAwarePaginator
     */
    public function all(string $searchText = '', array $sortBy = []): LengthAwarePaginator
    {
        return $this->customerRepository->all($searchText, $sortBy);
    }
}
