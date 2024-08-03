<?php

namespace App\Livewire\Pages;

use App\Models\Customer;
use App\Services\CartService;
use App\Services\CustomerService;
use App\Services\ProductService;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
use Livewire\Component;

class CreateOrder extends Component
{
    public ?Customer $customer;

    public ?int $user_searchable_id;

    public $isCustomerModalOpen = false;

    public $headers = [
        ['key' => 'id', 'label' => '#'],
        ['key' => 'name', 'label' => 'Name'],
        ['key' => 'quantity', 'label' => 'Qty'],
        ['key' => 'sellPrice', 'label' => 'Price'],
        ['key' => 'totalValue', 'label' => 'Sub Total'],
    ];

    public $carts;

    public Collection $usersSearchable;

    public $search = '';

    public array $sortBy = ['column' => 'id', 'direction' => 'asc'];

    // Options list

    protected CustomerService $customerService;

    protected CartService $cartService;

    protected ProductService $productService;

    public function boot(CustomerService $customerService, ProductService $productService, CartService $cartService): void
    {
        $this->customerService = $customerService;
        $this->cartService = $cartService;
        $this->productService = $productService;
    }

    public function mount(): void
    {
        $this->searchCustomers();
    }

    public function updateQuantity(int $productId, int $currentQuantity, bool $isIncrement): void
    {
        $this->cartService->updateQuantity($this->user_searchable_id, $productId, $currentQuantity, $isIncrement);
        $this->carts = $this->getCarts();
    }

    public function addItem(int $productId): void
    {
        $this->cartService->addToCart($this->user_searchable_id, $productId);
        $this->carts = $this->getCarts();
    }

    public function getTotalPrice(): int
    {
        if ($this->carts) {
            return collect($this->carts)->sum('totalValue');
        }

        return 0;
    }

    public function createOrder(): void
    {
        $this->cartService->createOrder($this->user_searchable_id);

        $this->redirectRoute('orders');
    }

    public function searchCustomers(string $searchText = ''): LengthAwarePaginator|Collection
    {
        return $this->usersSearchable = $this->customerService
            ->all($searchText, ['name']);
    }

    public function selectCustomer(): void
    {
        $this->customer = $this->customerService->find($this->user_searchable_id);
        $this->isCustomerModalOpen = false;
        $this->carts = $this->getCarts();
    }

    public function getProducts()
    {
        return $this->productService->all(searchText: $this->search, sortBy: $this->sortBy, isReadyForSale: true);
    }

    public function getCarts()
    {
        return $this->cartService->getCarts($this->user_searchable_id);
    }

    public function deleteCustomer(): void
    {
        $this->customer = null;
        $this->user_searchable_id = null;
    }

    public function cancelCustomer(): void
    {
        $this->isCustomerModalOpen = false;
        $this->customer = null;
        $this->user_searchable_id = null;
    }

    public function render(): \Illuminate\Contracts\View\View|\Illuminate\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View|\Illuminate\Contracts\Foundation\Application
    {
        return view('livewire.pages.order.create-order', [
            'products' => $this->getProducts(),
            'carts' => $this->carts,
        ]);
    }
}
