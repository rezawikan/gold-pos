<?php

namespace App\Services;

use App\Models\Customer;
use App\Models\CustomerCart;
use App\Models\Order;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class CartService
{
    public function __construct(protected ProductService $productService) {}

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
     * Maps the given array of carts to an array of product information.
     *
     * @param  Collection  $carts  The array of carts to map.
     * @return array The array of product information.
     */
    protected function CartMapping(Collection $carts): array
    {
        $result = [];

        foreach ($carts as $cart) {
            $quantity = $cart->pivot->quantity;
            $sellPrice = $cart->product_prices->first()->sell_price;

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

    public function addToCart(int $customerId, int $productId): void
    {
        $customer = Customer::find($customerId);
        $cartExist = $customer->cart->find($productId);
        $availableStock = $this->productService->getAvailableStock($productId);

        if ($cartExist) {
            $quantity = $cartExist->pivot->quantity += 1;

            if ($quantity > $availableStock) {
                $quantity = $availableStock;
            }
            $cartExist->pivot->quantity = $quantity;
            $cartExist->pivot->save();

            return;
        }
        if ($availableStock == 0) {
            return;
        }
        $customer->cart()->attach([$productId => ['quantity' => 1]]);
    }

    /**
     * Deletes a cart associated with a customer.
     *
     * @param  int  $customerId  The ID of the customer.
     * @param  int  $productId  The ID of the product in the cart.
     * @return void
     */
    public function deleteCart(int $customerId, int $productId): void
    {
        $customer = Customer::find($customerId);
        $customer->cart()->detach($productId);
    }

    /**
     * Updates the quantity of a product in the customer's cart.
     *
     * @param  int  $customerId  The ID of the customer.
     * @param  int  $productId  The ID of the product.
     * @param  int  $currentQuantity  The current quantity of the product.
     * @param  bool  $isIncrement  Whether to increment or decrement the quantity.
     * @return void
     */
    public function updateQuantity(int $customerId, int $productId, int $currentQuantity, bool $isIncrement): void
    {
        $customer = Customer::find($customerId);
        $availableStock = $this->productService->getAvailableStock($productId);
        if ($isIncrement) {
            $quantity = $currentQuantity + 1;
        } else {
            $quantity = $currentQuantity - 1;
            if ($quantity == 0) {
                $this->deleteCart($customerId, $productId);

                return;
            }
        }

        if ($availableStock == 0) {
            return;
        }

        if ($quantity > $availableStock) {
            $quantity = $availableStock;
        }

        $customer->cart()->updateExistingPivot($productId, ['quantity' => $quantity]);
    }

    public function createOrder($customerId): void
    {
        DB::transaction(function () use ($customerId) {
            $customer = Customer::find($customerId);

            if (! $customer) {
                throw new ModelNotFoundException('Customer not found.');
            }

            $subtotal = 0;
            $baseSubtotal = 0;
            $discount = 0; // Assuming discount logic is implemented elsewhere

            $order = Order::create([
                'customer_id' => $customerId,
                'subtotal' => $subtotal,
                'base_subtotal' => $baseSubtotal,
                'discount' => $discount,
                'total' => 0,
                'profit' => 0,
            ]);

            $customer->cart()->each(function ($cart) use ($order, &$subtotal, &$baseSubtotal) {
                $quantity = $cart->pivot->quantity;
                $productItems = $cart->product_items->sortBy(function ($item) {
                    return $item->based_price;
                });
                //                dd($productItems);
                $productPrice = $cart->product_prices->first()->sell_price;
                $subtotal += $productPrice * $quantity;

                foreach ($productItems as $item) {
                    if ($quantity == 0) {
                        break;
                    }

                    $orderItemQuantity = min($quantity, $item->stock);
                    $quantity -= $orderItemQuantity;
                    $item->stock -= $orderItemQuantity;
                    $baseSubtotal += $orderItemQuantity * $item->based_price;

                    $order->items()->create([
                        'based_price' => $item->based_price,
                        'price' => $productPrice,
                        'quantity' => $orderItemQuantity,
                        'grams' => $cart->grams,
                    ]);

                    if ($item->stock == 0) {
                        $item->delete();
                    } else {
                        $item->save();
                    }
                }
            });

            $total = $subtotal - $discount;
            $profit = $total - $baseSubtotal;

            $order->update([
                'subtotal' => $subtotal,
                'base_subtotal' => $baseSubtotal,
                'total' => $total,
                'profit' => $profit,
            ]);

            // remove cart
            $customer->cart()->detach();
        });
    }
}
