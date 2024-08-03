<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Product extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'brand_id',
        'type_id',
        'name',
        'slug',
        'additional_sell_price',
        'additional_buy_price',
        'grams',
    ];

    /**
     * Get the product items for the product.
     */
    public function product_items(): HasMany
    {
        return $this->hasMany(ProductItem::class);
    }

    /**
     * Get the product prices for the product.
     */
    public function product_prices(): HasMany
    {
        return $this->hasMany(ProductPrice::class);
    }

    /**
     * Get the brand that owns the product.
     *
     * @return \Illuminate\Database\Eloquent\Relations\belongsTo
     */
    public function brand(): belongsTo
    {
        return $this->belongsTo(Brand::class);
    }
}
