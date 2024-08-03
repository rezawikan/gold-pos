<?php

namespace App\Services;

use App\Models\Customer;
use App\Repositories\Interface\CustomerRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

class CustomerService
{
    /**
     * Constructs a new instance of the class.
     *
     * @param  CustomerRepositoryInterface  $customerRepository
     */
    public function __construct(protected CustomerRepositoryInterface $customerRepository) {}

    /**
     * Retrieve all customers.
     *
     * @param  string  $searchText
     * @param  array  $sortBy
     * @param  bool  $isPaginated
     * @return LengthAwarePaginator|Collection
     */
    public function all(string $searchText = '', array $sortBy = [], bool $isPaginated = false): LengthAwarePaginator|Collection
    {
        return $this->customerRepository->all($searchText, $sortBy, $isPaginated);
    }

    /**
     * Find customer by id.
     *
     * @param  int|null  $id
     * @return Customer|null
     */
    public function find(?int $id): ?Customer
    {
        return $this->customerRepository->find($id);
    }

    public function getCarts(int $customerId): array
    {
        return $this->customerRepository->getCarts($customerId);
    }

    public function deleteCart(int $customerId, int $productId): void
    {
        $this->customerRepository->deleteCart($customerId, $productId);
    }

    public function updateQuantity(int $customerId, int $productId, int $quantity): void
    {
        $customer = $this->customerRepository->find($customerId);
        $this->customerRepository->updateQuantity($customer, $productId, $quantity);
    }
}
