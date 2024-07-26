<?php

namespace App\Livewire\Pages;

use App\Livewire\Forms\GoldForm;
use App\Services\BrandService;
use App\Services\ProductService;
use App\Services\TypeService;
use Illuminate\Support\Str;
use Livewire\Component;

class UpdateGold extends Component
{
    public $product;

    public $isEditMode = false;

    public GoldForm $form;

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
        $this->validate();

        if ($this->isEditMode) {
            $this->form->update();
        } else {
            $this->form->store();
        }

        session()->flash('status', 'Successfully updated the gold -'.$this->form->name);
        session()->flash('statusType', 'success');
        $this->redirectRoute('gold-stock');
    }

    public function render(): \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Foundation\Application|\Illuminate\View\View|\Illuminate\Contracts\Foundation\Application
    {
        return view('livewire.pages.update-gold');
    }
}
