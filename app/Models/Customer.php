<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Customer extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'email',
        'name',
        'phone_number',
        'address',
    ];

    /**
     * Get the cart that owns the customer.
     */
    public function cart(): BelongsToMany
    {
        return $this->belongsToMany(Product::class, 'cart_customers')
            ->with(['product_prices' => function ($query) {
                $query->latest('date')->first();
            }])
            ->with(['product_items' => function ($query) {
                $query->orderBy('based_price', 'desc');
            }])
            ->withPivot('quantity')
            ->withTimestamps();
    }
}
