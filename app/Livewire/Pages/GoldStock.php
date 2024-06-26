<?php

namespace App\Livewire\Pages;

use App\Services\ProductService;
use Livewire\Attributes\Layout;
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

    public $tableData;
    public $today;

    public function mount(ProductService $productService): void
    {
        $this->tableData = $productService->all();
        $this->today = now()->format('Y-m-d');
    }

    #[Layout('components.layouts.app')]
    public function render(): \Illuminate\Contracts\View\Factory|\Illuminate\Foundation\Application|\Illuminate\Contracts\View\View|\Illuminate\View\View|\Illuminate\Contracts\Foundation\Application
    {
        return view('livewire.pages.gold-stock');
    }
}
