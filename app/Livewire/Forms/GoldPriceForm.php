<?php

namespace App\Livewire\Forms;

use App\Models\Product;
use App\Rules\DateExistRule;
use Illuminate\Support\Str;
use Livewire\Attributes\On;
use Livewire\Component;

class GoldPriceForm extends Component
{
    public $formTitle;

    public $product;

    public $price;

    public $date;

    public function rules(): array
    {
        return [
            'date' => [
                'required',
                new DateExistRule($this->product->id),
            ],
            'price' => 'required',
        ];
    }

    public function render(): \Illuminate\Contracts\View\Factory|\Illuminate\Foundation\Application|\Illuminate\Contracts\View\View|\Illuminate\View\View|\Illuminate\Contracts\Foundation\Application
    {
        return view('livewire.forms.gold-price-form');
    }

    #[On('update-price')]
    public function edit($id): void
    {
        $this->formTitle = 'Add Today\'s Price';
        $this->product = Product::find($id);
        $this->price = null;
    }

    #[On('add-price-close')]
    public function close(): void
    {
        $this->reset();
        $this->resetValidation();
    }

    public function updatePrice(): void
    {
        $this->date = now();
        $this->validate();

        Product::find($this->product->id)->product_prices()
            ->create([
                'price' => (int) Str::replace(',', '', $this->price),
                'date' => $this->date,
            ]);

        $this->dispatch('refresh-products', status: 'Successfully added new price for '.$this->product->name, statusType: 'success');
        $this->reset();
    }
}
