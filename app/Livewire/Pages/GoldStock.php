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

    public $filters = [
        'hide_stock' => false,
    ];

    public $filterCount = 0;

    public $pageTitle = 'Gold Stock';

    public $search = '';

    public $today;

    public $status;

    public bool $showDrawerFilter = false;

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
     * Apply the filters.
     *
     * @return void
     */
    public function applyFilters(): void
    {
        foreach ($this->filters as $key => $value) {
            if ($key == 'hide_stock' && $value) {
                $this->headers = array_filter($this->headers, function ($header) {
                    return $header['key'] != 'stock';
                });
                $this->filterCount++;
            } else {
                $first = array_slice($this->headers, 0, 3);
                $res = array_slice($this->headers, -2, 2, true);
                $this->headers = array_merge($first, [['key' => 'stock', 'label' => 'Stock']], $res);
                $this->filterCount--;
            }
        }

        $this->showDrawerFilter = false;
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
