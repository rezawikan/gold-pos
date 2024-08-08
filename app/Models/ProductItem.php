<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class ProductItem extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'product_id',
        'based_price',
        'stock',
        'purchase_date',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'purchase_date' => 'datetime',
        ];
    }

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * Get the scope indicator
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return void
     */
    public function scopeIndicator(Builder $query): void
    {
        $query->leftJoin('product_prices AS current_record', function ($join) {
            $join->on('product_items.product_id', '=', 'current_record.product_id')
                ->whereDate('current_record.date', '=', DB::raw('CURDATE()'));
        })->leftJoin('product_prices AS latest_record', function ($join) {
            $join->on('product_items.product_id', '=', 'latest_record.product_id')
                ->where('latest_record.date', '=', function ($query) {
                    $query->select(DB::raw('MAX(date)'))
                        ->from('product_prices')
                        ->whereColumn('product_id', 'latest_record.product_id')
                        ->latest('latest_record.date');
                });
        })
            ->selectRaw("
                    product_items.*,
                    CASE 
                        WHEN (COALESCE(current_record.sell_price, latest_record.sell_price, 0) - product_items.based_price) < 0 THEN 'zinc'
                        WHEN (COALESCE(current_record.sell_price, latest_record.sell_price, 0) - product_items.based_price) BETWEEN 0 AND 5000 THEN 'red'
                        WHEN (COALESCE(current_record.sell_price, latest_record.sell_price, 0) - product_items.based_price) BETWEEN 5001 AND 10000 THEN 'orange'
                        WHEN (COALESCE(current_record.sell_price, latest_record.sell_price, 0) - product_items.based_price) BETWEEN 10001 AND 20000 THEN 'emerald'
                        WHEN (COALESCE(current_record.sell_price, latest_record.sell_price, 0) - product_items.based_price) BETWEEN 20001 AND 50000 THEN 'sky'
                        WHEN (COALESCE(current_record.sell_price, latest_record.sell_price, 0) - product_items.based_price) BETWEEN 50001 AND 100000 THEN 'violet'
                        ELSE 'pink'
                    END as status_color
                ");
    }
}
