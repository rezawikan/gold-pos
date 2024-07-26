<?php

namespace App\Services;

use App\Models\Brand;

class BrandService
{
    public function __construct() {}

    public function all(): \Illuminate\Database\Eloquent\Collection
    {
        return Brand::all();
    }
}
