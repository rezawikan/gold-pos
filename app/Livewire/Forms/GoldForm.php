<?php

namespace App\Livewire\Forms;

use App\Models\Product;
use Illuminate\Validation\Rule;
use Livewire\Form;

class GoldForm extends Form
{
    public ?Product $product;

    public $isEditMode = false;

    public $brand_id;

    public $type_id;

    public $name;

    public $slug;

    public $additional_sell_price;

    public $additional_buy_price;

    public $grams;

    /**
     * Return the validation rules that apply to the request.
     *
     * @return array|string[]
     */
    public function rules(): array
    {
        return [
            'name' => 'required',
            'slug' => 'required',
            'additional_sell_price' => 'nullable',
            'additional_buy_price' => 'nullable',
            'brand_id' => 'required',
            'type_id' => 'required',
            'grams' => [
                'required',
                Rule::in([0.5, 1, 2, 3, 5, 10, 25, 50, 100]),
            ],
        ];
    }

    /**
     * Set the product.
     *
     * @param  \App\Models\Product  $product
     * @return void
     */
    public function setProduct(Product $product): void
    {
        $this->product = $product;
        $this->brand_id = $product->brand_id;
        $this->type_id = $product->type_id;
        $this->name = $product->name;
        $this->slug = $product->slug;
        $this->additional_sell_price = numberFormatter($product->additional_sell_price);
        $this->additional_buy_price = numberFormatter($product->additional_buy_price);
        $this->grams = $product->grams;
        $this->isEditMode = true;
    }

    /**
     * Store the product.
     *
     * @return \App\Models\Product
     */
    public function store(): Product
    {
        $this->validate();

        dd($this->pull());
        //        $product = Product::create(
        //            $this->pull()
        //        );

        //        $this->reset();

        return $product;
    }

    /**
     * Update the customer.
     *
     * @return void
     */
    public function update(): void
    {
        $this->validate();

        $this->product->update([
            ...$this->all(),
            'additional_sell_price' => intval(str_replace(',', '', $this->additional_sell_price)),
            'additional_buy_price' => intval(str_replace(',', '', $this->additional_buy_price)),
        ]);

        $this->reset();
    }
}
