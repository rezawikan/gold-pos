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

    public function getCarts(int $customerId): array
    {
        $carts = Customer::find($customerId)
            ->cart()
            ->get();

        return $this->CartMapping($carts);
    }

    public function getCart(int $customerId, int $productId)
    {
        return Customer::find($customerId)
            ->cart()
            ->where('product_id', $productId)
            ->first();
    }

    public function updateQuantity(Customer $customer, int $productId, int $quantity): void
    {
        $customer->cart()->updateExistingPivot($productId, ['quantity' => $quantity]);
    }

    public function deleteCart(int $customerId, int $productId): void
    {
        $customer = Customer::find($customerId);
        $customer->cart()->detach($productId);
    }
    protected function CartMapping($carts): array
    {
        $result = [];

        foreach ($carts as $cart) {
            $quantity = $cart->pivot->quantity;
            $sellPrice = $cart->product_prices[0]['sell_price'];

            // Create an associative array with the desired information
            $productInfo = [
                'id' => $cart->id,
                'name' => $cart->name,
                'quantity' => (int) $quantity,
                'totalValue' => (int) ($quantity * $sellPrice),
                'sellPrice' => (int) $sellPrice,
            ];

            $result[] = $productInfo;
        }

        return $result;
    }
}
