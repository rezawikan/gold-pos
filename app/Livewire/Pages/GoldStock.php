<?php

namespace App\Livewire\Pages;

use App\Services\CrawlerService;
use App\Services\ProductService;
use Livewire\Attributes\Layout;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithPagination;

class GoldStock extends Component
{
    use WithPagination;

    public array $sortBy = ['column' => 'id', 'direction' => 'asc'];

    public $headers = [
        ['key' => 'id', 'label' => '#'],
        ['key' => 'name', 'label' => 'Name'],
        ['key' => 'grams', 'label' => 'Grams'],
        ['key' => 'stock', 'label' => 'Stock'],
        ['key' => 'price', 'label' => 'Price'],
        ['key' => 'price_updated_at', 'label' => 'Last Update'],
    ];

    public $pageTitle = 'Gold Stock';

    public $search = '';

    public $today;

    public $status;

    protected $productService;
    protected $crawlerService;

    public function boot(ProductService $productService, CrawlerService $crawlerService): void
    {
        $this->crawlerService = $crawlerService;
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

    /**
     * Get the Antam price list from the specified URL.
     *
     * @return void
     */
    public function updatePrice(): void
    {
        $this->crawlerService->getAntamPriceList();
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
        return $this->productService->all($this->search, $this->sortBy);
    }
}
