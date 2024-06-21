<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return $products = Product::select('products.id', 'products.name', 'products.additional_price', 'products.grams')
            ->leftJoin('product_prices AS current_record', function ($join) {
                $join->on('products.id', '=', 'current_record.product_id')
                    ->whereDate('current_record.date', '=', DB::raw('CURDATE()'));
            })
            ->leftJoin('product_prices AS latest_record', function ($join) {
                $join->on('products.id', '=', 'latest_record.product_id')
                    ->where('latest_record.date', '=', function ($query) {
                        $query->select(DB::raw('MAX(date)'))
                            ->from('product_prices')
                            ->whereColumn('product_id', 'latest_record.product_id')
                            ->where('date', '<', DB::raw('CURDATE()'));
                    });
            })
            ->leftJoin('product_items AS PI', 'products.id', '=', 'PI.product_id')
            ->groupBy('products.id', 'products.name', 'products.additional_price', 'products.grams', 'products.updated_at', 'products.created_at')
            ->orderBy('products.id', 'ASC')
            ->selectRaw('
        products.id,
        products.name,
        products.additional_price,
        products.grams,
        COALESCE(MAX(current_record.price), MAX(latest_record.price)) AS price,
        COALESCE(MAX(current_record.date), MAX(latest_record.date)) AS price_updated_at,
        SUM(PI.stock) AS stock,
        products.updated_at,
        products.created_at
    ')
            ->get();

        return view('welcome');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
