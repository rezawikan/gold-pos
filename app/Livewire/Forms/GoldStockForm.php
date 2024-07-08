<?php

namespace App\Livewire\Forms;

use App\Models\Product;
use Illuminate\Support\Str;
use Livewire\Attributes\On;
use Livewire\Attributes\Validate;
use Livewire\Component;

class GoldStockForm extends Component
{
    public $formTitle;

    public $product;

    #[Validate('required')]
    public $basedPrice;

    #[Validate('required')]
    public $stock;

    public function render(): \Illuminate\Contracts\View\Factory|\Illuminate\Foundation\Application|\Illuminate\Contracts\View\View|\Illuminate\View\View|\Illuminate\Contracts\Foundation\Application
    {
        return view('livewire.forms.gold-stock-form');
    }

    #[On('add-stock')]
    public function edit($id): void
    {
        $this->formTitle = 'Add New Stock';
        $this->product = Product::find($id);
        $this->basedPrice = null;
        $this->stock = null;
    }

    #[On('add-stock-close')]
    public function close(): void
    {
        $this->reset();
        $this->resetValidation();
    }

    /**
     * @return void
     */
    public function addStock(): void
    {
        $this->validate();

        $id = $this->product->id;
        Product::find($id)->product_items()->create([
            'stock' => (int) Str::replace(',', '', $this->stock),
            'based_price' => (int) Str::replace(',', '', $this->basedPrice),
        ]);

        $this->dispatch('refresh-products', status: 'Successfully added stock for '.$this->product->name);
        $this->reset();
    }
}
