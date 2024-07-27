<?php

namespace App\Livewire\Forms;

use App\Models\ProductItem;
use Livewire\Attributes\Validate;
use Livewire\Form;

class GoldStockForm extends Form
{
    public ?ProductItem $productItem;

    public $isEditMode = false;

    #[Validate('required')]
    public $basedPrice;

    #[Validate('required')]
    public $stock;

    /**
     * Set the product item.
     *
     * @param  \App\Models\ProductItem  $productItem
     * @return void
     */
    public function setProductItem(ProductItem $productItem): void
    {
        $this->productItem = $productItem;
        $this->isEditMode = true;
        $this->basedPrice = numberFormatter($productItem->based_price);
        $this->stock = numberFormatter($productItem->stock);
    }

    /**
     * Update the gold stock.
     *
     * @return void
     */
    public function update(): void
    {
        $this->validate();

        $this->productItem->update([
            ...$this->only('stock'),
            'based_price' => removeAlphabets($this->basedPrice),
        ]);

        $this->reset();
    }
}
