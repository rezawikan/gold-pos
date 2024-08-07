<?php

namespace App\Livewire\Pages;

use App\Livewire\Forms\GoldForm;
use App\Services\BrandService;
use App\Services\CrawlerService;
use App\Services\ProductService;
use App\Services\TypeService;
use Illuminate\Support\Str;
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
        ['key' => 'product_brand', 'label' => 'Brand'],
        ['key' => 'product_type', 'label' => 'Type'],
        ['key' => 'grams', 'label' => 'Grams'],
        ['key' => 'stock', 'label' => 'Stock'],
        ['key' => 'sell_price', 'label' => 'Sell Price'],
        ['key' => 'buy_price', 'label' => 'Buy Price'],
        ['key' => 'price_updated_at', 'label' => 'Last Update'],
        ['key' => 'actions', 'label' => 'Actions'],
    ];

    public $filters = [
        'hide_stock' => false,
    ];

    public $filterCount = 0;

    public $pageTitle = 'Gold Stock';

    public $search = '';

    public $today;

    public $status;

    public $statusType;

    public bool $showDrawerFilter = false;

    public bool $goldStockModal = false;

    public GoldForm $form;

    public $types;

    public $brands;

    protected BrandService $brandService;

    protected TypeService $typeService;

    protected ProductService $productService;

    protected $crawlerService;

    public function boot(ProductService $productService, CrawlerService $crawlerService, BrandService $brandService, TypeService $typeService): void
    {
        $this->crawlerService = $crawlerService;
        $this->productService = $productService;
        $this->brandService = $brandService;
        $this->typeService = $typeService;
        $this->today = now()->format('Y-m-d');
    }

    public function mount(): void
    {
        $this->types = $this->typeService->all();
        $this->brands = $this->brandService->all();
    }

    public function openModal($isEditMode = false): void
    {
        $this->goldStockModal = true;
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

                $this->headers = array_map(function ($header) {
                    if ($header['key'] == 'stock') {
                        return ['key' => 'stock', 'label' => 'Stock', 'hidden' => true];
                    }

                    return $header;
                }, $this->headers);

                $this->filterCount++;
            } else {
                $this->headers = array_map(function ($header) {
                    if ($header['key'] == 'stock') {
                        return ['key' => 'stock', 'label' => 'Stock', 'hidden' => false];
                    }

                    return $header;
                }, $this->headers);
                $this->filterCount--;
            }
        }

        $this->showDrawerFilter = false;
    }

    /**
     * Generate the slug.
     *
     * @return void
     */
    public function generateSlug(): void
    {
        $this->form->slug = Str::slug($this->form->name);
    }

    /**
     * Add the stock.
     *
     * @return void
     */
    public function addStock(): void
    {
        $product = $this->form->store();
        $this->goldStockModal = false;

        $this->redirectRoute('update-gold', ['id' => $product->id]);
    }

    /**
     * Generate the delimiters.
     *
     * @param  string  $form
     * @param  string  $type
     * @return void
     */
    public function generateDelimiters(string $form, string $type): void
    {
        $removeDot = str_replace('.', '', $this->{$form}->{$type});
        $this->{$form}->{$type} = numberFormatter($removeDot);
    }

    /**
     * Get the Antam price list from the specified URL.
     *
     * @return void
     */
    public function updatePrice(): void
    {
        try {
            $this->crawlerService->getAntamPriceList();
        } catch (\Exception $exception) {
            $this->dispatch('refresh-products', status: $exception->getMessage(), statusType: 'warning');
        }

        $this->refresh(status: 'The price has been updated', statusType: 'success');
    }

    #[On('refresh-products')]
    public function refresh(string $status, string $statusType): void
    {
        $this->status = $status;
        $this->statusType = $statusType;
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
        return $this->productService->all($this->search, $this->sortBy, true, true);
    }
}
