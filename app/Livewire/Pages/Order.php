<?php

namespace App\Livewire\Pages;

use App\Services\OrderService;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View as ViewContract;
use Illuminate\View\View;
use Livewire\Component;

class Order extends Component
{
    public $search = '';

    public array $sortBy = ['column' => 'id', 'direction' => 'asc'];

    public $headers = [
        ['key' => 'id', 'label' => '#'],
        ['key' => 'customer.name', 'label' => 'Name'],
        ['key' => 'subtotal', 'label' => 'Subtotal'],
        ['key' => 'base_subtotal', 'label' => 'Base Subtotal'],
        ['key' => 'discount', 'label' => 'Discount'],
        ['key' => 'total', 'label' => 'Total'],
        ['key' => 'profit', 'label' => 'Profit'],
        ['key' => 'created_at', 'label' => 'Created At'],
    ];

    protected $orderService;

    public function boot(OrderService $orderService): void
    {
        $this->orderService = $orderService;
    }

    public function getOrders()
    {
        return $this->orderService->all($this->search, $this->sortBy, true);
    }

    public function render(): Factory|View|ViewContract|Application
    {
        return view('livewire.pages.order.orders', [
            'orders' => $this->getOrders(),
        ]);
    }
}
