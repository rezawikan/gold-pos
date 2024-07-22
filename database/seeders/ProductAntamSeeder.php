<?php

namespace Database\Seeders;

use App\Models\Brand;
use App\Models\Product;
use App\Models\Type;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ProductAntamSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Brand::upsert([
            ['id' => 1, 'name' => 'Antam'],
        ], [
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        Type::upsert([
            ['id' => 1, 'name' => 'Bar Series'],
            ['id' => 2, 'name' => 'Gift Series'],
        ],
            [
                'created_at' => now(),
                'updated_at' => now(),
            ], [
                'created_at' => now(),
                'updated_at' => now(),
            ]);

        Product::upsert(
            [
                [
                    'brand_id' => 1,
                    'type_id' => 1,
                    'name' => 'Emas Antam Batangan 0.5 gr',
                    'slug' => Str::slug('Emas Antam Batangan 0.5 gr'),
                    'additional_sell_price' => 10000,
                    'additional_buy_price' => 30000,
                    'grams' => 0.5,
                ],
                [
                    'brand_id' => 1,
                    'type_id' => 1,
                    'name' => 'Emas Antam Batangan 1 gr',
                    'slug' => Str::slug('Emas Antam Batangan 1 gr'),
                    'additional_sell_price' => 10000,
                    'additional_buy_price' => 30000,
                    'grams' => 1,
                ],
                [
                    'brand_id' => 1,
                    'type_id' => 1,
                    'name' => 'Emas Antam Batangan 2 gr',
                    'slug' => Str::slug('Emas Antam Batangan 2 gr'),
                    'additional_sell_price' => 20000,
                    'additional_buy_price' => 30000,
                    'grams' => 2,
                ],
                [
                    'brand_id' => 1,
                    'type_id' => 1,
                    'name' => 'Emas Antam Batangan 3 gr',
                    'slug' => Str::slug('Emas Antam Batangan 3 gr'),
                    'additional_sell_price' => 20000,
                    'additional_buy_price' => 30000,
                    'grams' => 3,
                ],
                [
                    'brand_id' => 1,
                    'type_id' => 1,
                    'name' => 'Emas Antam Batangan 5 gr',
                    'slug' => Str::slug('Emas Antam Batangan 5 gr'),
                    'additional_sell_price' => 30000,
                    'additional_buy_price' => 30000,
                    'grams' => 5,
                ],
                [
                    'brand_id' => 1,
                    'type_id' => 1,
                    'name' => 'Emas Antam Batangan 10 gr',
                    'slug' => Str::slug('Emas Antam Batangan 10 gr'),
                    'additional_sell_price' => 30000,
                    'additional_buy_price' => 30000,
                    'grams' => 10,
                ],
                [
                    'brand_id' => 1,
                    'type_id' => 1,
                    'name' => 'Emas Antam Batangan 25 gr',
                    'slug' => Str::slug('Emas Antam Batangan 25 gr'),
                    'additional_sell_price' => 50000,
                    'additional_buy_price' => 30000,
                    'grams' => 25,
                ],
                [
                    'brand_id' => 1,
                    'type_id' => 1,
                    'name' => 'Emas Antam Batangan 50 gr',
                    'slug' => Str::slug('Emas Antam Batangan 50 gr'),
                    'additional_sell_price' => 100000,
                    'additional_buy_price' => 30000,
                    'grams' => 50,
                ],
                [
                    'brand_id' => 1,
                    'type_id' => 1,
                    'name' => 'Emas Antam Batangan 100 gr',
                    'slug' => Str::slug('Emas Antam Batangan 100 gr'),
                    'additional_sell_price' => 100000,
                    'additional_buy_price' => 30000,
                    'grams' => 100,
                ],
            ],
            [
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'created_at' => now(),
                'updated_at' => now(),
            ]);
    }
}
