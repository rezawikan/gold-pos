<?php

namespace App\Livewire\Forms;

use App\Models\ProductItem;
use DateTime;
use Livewire\Attributes\Validate;
use Livewire\Form;

class GoldStockForm extends Form
{
    public ?ProductItem $productItem;

    public $productId;

    public $isEditMode = false;

    #[Validate('required')]
    public $basedPrice;

    #[Validate('required')]
    public $stock;

    #[Validate('required')]
    public $purchaseDate;

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
        $this->purchaseDate = $productItem->purchase_date;
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
            'purchase_date' => $this->purchaseDate,
        ]);

        $this->reset();
    }

    /**
     * Store the gold stock.
     *
     * @return void
     * @throws \Exception
     */
    public function store(): void
    {
        $this->validate();

        ProductItem::create([
            ...$this->only('stock'),
            'based_price' => removeAlphabets($this->basedPrice),
            'product_id' => $this->productId,
            'purchase_date' => new DateTime($this->purchaseDate),
        ]);

        $this->reset();
    }
}
