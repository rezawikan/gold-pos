<?php

namespace App\Repositories;

use App\Models\Customer;
use App\Models\CustomerCart;
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

    /**
     * Retrieves the carts associated with a customer.
     *
     * @param  int  $customerId  The ID of the customer.
     * @return array An array of cart objects associated with the customer.
     */
    public function getCarts(int $customerId): array
    {
        $carts = Customer::find($customerId)
            ->cart()
            ->get();

        return $this->CartMapping($carts);
    }

    /**
     * Retrieves the cart associated with a customer for a specific product.
     *
     * @param  int  $customerId  The ID of the customer.
     * @param  int  $productId  The ID of the product.
     * @return CustomerCart|null The cart associated with the customer and product, or null if not found.
     */
    public function getCart(int $customerId, int $productId): ?CustomerCart
    {
        return Customer::find($customerId)
            ->cart()
            ->where('product_id', $productId)
            ->first();
    }

    /**
     * Updates the quantity of a product in the customer's cart.
     *
     * @param  Customer  $customer  The customer object.
     * @param  int  $productId  The ID of the product.
     * @param  int  $quantity  The new quantity of the product.
     * @return void
     */
    public function updateQuantity(Customer $customer, int $productId, int $quantity): void
    {
        $customer->cart()->updateExistingPivot($productId, ['quantity' => $quantity]);
    }

    /**
     * Deletes a product from the cart of a customer.
     *
     * @param  int  $customerId  The ID of the customer.
     * @param  int  $productId  The ID of the product to be deleted from the cart.
     * @return void
     */
    public function deleteCart(int $customerId, int $productId): void
    {
        $customer = Customer::find($customerId);
        $customer->cart()->detach($productId);
    }

    /**
     * Maps the given array of carts to an array of product information.
     *
     * @param  array  $carts  The array of carts to map.
     * @return array The array of product information.
     */
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
