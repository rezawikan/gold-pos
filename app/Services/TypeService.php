<?php

namespace App\Services;

use App\Models\Type;

class TypeService
{
    public function __construct() {}

    public function all(): \Illuminate\Database\Eloquent\Collection
    {
        return Type::all();
    }
}
