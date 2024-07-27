<?php

namespace App\Livewire\Pages;

use App\Livewire\Forms\GoldForm;
use App\Livewire\Forms\GoldStockForm;
use App\Models\ProductItem;
use App\Services\BrandService;
use App\Services\ProductService;
use App\Services\TypeService;
use Illuminate\Support\Str;
use Livewire\Attributes\On;
use Livewire\Component;

class UpdateGold extends Component
{
    public $product;

    public $isEditMode = false;

    public $editStockModal = false;
    public $deleteStockModal = false;

    public $isEditModeStock = false;

    public GoldForm $form;

    public GoldStockForm $stockForm;

    public ProductItem $selectedItemForDelete;

    public $statusStock;
    public $statusTypeStock;

    public $productItemHeaders = [
        ['key' => 'id', 'label' => 'ID'],
        ['key' => 'based_price', 'label' => 'Based Price'],
        ['key' => 'stock', 'label' => 'Stock'],
    ];

    protected ProductService $productService;

    protected BrandService $brandService;

    protected TypeService $typeService;

    public $types;

    public $brands;

    /**
     * @param  \App\Services\ProductService  $productService
     * @param  \App\Services\BrandService  $brandService
     * @param  \App\Services\TypeService  $typeService
     * @return void
     */
    public function boot(ProductService $productService, BrandService $brandService, TypeService $typeService): void
    {
        $this->productService = $productService;
        $this->brandService = $brandService;
        $this->typeService = $typeService;
    }

    public function mount($id): void
    {
        $this->product = $this->productService->find($id);
        $this->form->setProduct($this->product);
        $this->form->setProductItems($this->product->product_items()->get());
        $this->isEditMode = true;

        $this->types = $this->typeService->all();
        $this->brands = $this->brandService->all();
    }

    public function generateSlug(): void
    {
        $this->form->slug = Str::slug($this->form->name);
    }

    public function save(): void
    {
        if ($this->isEditMode) {
            $this->form->update();
        } else {
            $this->form->store();
        }

        session()->flash('status', 'Successfully updated the gold');
        $this->redirectRoute('gold-stock');
    }

    public function updateStock(): void
    {
        $this->validate();

        if ($this->isEditModeStock) {
            $this->stockForm->update();
            $this->dispatch('refresh-stock', status: 'Successfully updated the stock', statusType: 'success');
        }
    }

    public function generateDelimiters(string $form, string $type): void
    {
        $removeDot = str_replace('.', '', $this->{$form}->{$type});
        $this->{$form}->{$type} = numberFormatter($removeDot);
    }

    public function openEditModal(int $id, bool $isEditModeModal = false): void
    {
        $this->editStockModal = true;
        $this->isEditModeStock = $isEditModeModal;
        $this->stockForm->setProductItem($this->product->product_items()->find($id));
    }

    public function openDeleteModal(int $id): void
    {
        $this->deleteStockModal = true;
        $this->selectedItemForDelete = $this->product->product_items()->find($id);
    }

    public function deleteProductItem(): void
    {
        $this->deleteStockModal = false;
        $this->selectedItemForDelete->delete();
        $this->dispatch('refresh-stock', status: 'Successfully deleted the product item', statusType: 'success');
    }

    #[On('refresh-stock')]
    public function refresh(string $status, string $statusType): void
    {
        $this->isEditModeStock = false;
        $this->editStockModal = false;
        $this->form->setProductItems($this->product->product_items()->get());
        $this->statusStock = $status;
        $this->statusTypeStock = $statusType;
    }

    public function render(): \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Foundation\Application|\Illuminate\View\View|\Illuminate\Contracts\Foundation\Application
    {
        return view('livewire.pages.update-gold');
    }
}
