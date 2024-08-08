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
        ['key' => 'purchase_date', 'label' => 'Purchase Date'],
        ['key' => 'status_color', 'label' => 'Indicator', 'class' => 'flex justify-center'],
        ['key' => 'actions', 'label' => 'Actions'],
    ];

    public $types;

    public $brands;

    public $datePickerOptions = [
        'enableTime' => true,
        'enableSeconds' => true,
        'dateFormat' => 'Y-m-d H:i:s',
    ];

    public $indicators = [
        'zinc' => 'Not Available',
        'red' => 'Between 0 and 5',
        'orange' => 'Between 5.1 and 10',
        'emerald' => 'Between 10.1 and 20',
        'sky' => 'Between 20.1 and 50',
        'violet' => 'Between 50.1 and 100',
        'pink' => 'More than 100',
    ];

    protected ProductService $productService;

    protected BrandService $brandService;

    protected TypeService $typeService;

    /**
     * @param  ProductService  $productService
     * @param  BrandService  $brandService
     * @param  TypeService  $typeService
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
        $this->form->setProductItems(
            $this->product->product_items()->indicator()->get()
        );

        $this->types = $this->typeService->all();
        $this->brands = $this->brandService->all();
    }

    public function generateSlug(): void
    {
        $this->form->slug = Str::slug($this->form->name);
    }

    public function updateStock(): void
    {
        $this->validate();

        if ($this->isEditModeStock) {
            $this->stockForm->update();
            $this->dispatch('refresh-stock', status: 'Successfully updated the stock', statusType: 'success');
        } else {
            $this->stockForm->store();
            $this->dispatch('refresh-stock', status: 'Successfully added the stock', statusType: 'success');
        }
    }

    public function update(): void
    {
        $this->form->update();

        session()->flash('status', 'Successfully updated the gold');
        $this->redirectRoute('gold-stock');
    }

    public function generateDelimiters(string $form, string $type): void
    {
        $removeDot = str_replace('.', '', $this->{$form}->{$type});
        $this->{$form}->{$type} = numberFormatter($removeDot);
    }

    public function openAddModal(): void
    {
        $this->editStockModal = true;
        $this->isEditModeStock = false;
        $this->stockForm->productId = $this->product->id;
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

    public function closeEditModal(): void
    {
        $this->editStockModal = false;
        $this->stockForm->reset();
        $this->isEditModeStock = false;
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
