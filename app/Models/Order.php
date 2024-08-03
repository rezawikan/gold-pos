<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Order extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'customer_id',
        'subtotal',
        'base_subtotal',
        'discount',
        'total',
        'profit',
    ];

    /**
     * Get the customer that owns the order dynamic.
     */
    public function customer(): HasOne
    {
        return $this->hasOne(Customer::class);
    }
}
