<?php

namespace App\Livewire\Pages;

use App\Services\ProductService;
use Livewire\Attributes\Layout;
use Livewire\Attributes\On;
use Livewire\Component;

class GoldStock extends Component
{
    public $breadcrumbItems = [
        [
            'name' => 'Gold Stock',
            'url' => '/gold-stock',
            'active' => true,
        ],
    ];

    public $pageTitle = 'Gold Stock';

    public $search = '';

    public $today;

    public $status;

    protected $productService;

    public function boot(ProductService $productService): void
    {
        $this->productService = $productService;
        $this->today = now()->format('Y-m-d');
    }

    #[On('refresh-products')]
    public function refresh(string $status): void
    {
        $this->status = $status;
    }

    public function closeStatus(): void
    {
        $this->status = null;
    }

    #[Layout('components.layouts.app')]
    public function render(): \Illuminate\Contracts\View\Factory|\Illuminate\Foundation\Application|\Illuminate\Contracts\View\View|\Illuminate\View\View|\Illuminate\Contracts\Foundation\Application
    {
        return view('livewire.pages.gold-stock', [
            'products' => $this->getProducts(),
        ]);
    }

    public function getProducts()
    {
        return $this->productService->all($this->search);
    }


}
