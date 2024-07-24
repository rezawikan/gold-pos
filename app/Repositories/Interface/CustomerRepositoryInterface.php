<?php

namespace App\Repositories\Interface;

use Illuminate\Pagination\LengthAwarePaginator;

interface CustomerRepositoryInterface
{
    public function all(string $searchText = '', array $sortBy = []): LengthAwarePaginator;
}
