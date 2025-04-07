<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Size;
use App\Models\SizePrice;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SizePriceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $smoothies = Category::where('nama', 'Smoothies')->first();

        $prices = [
            'M' => 10000,
            'L' => 12000,
            'XL' => 15000,
        ];

        foreach ($prices as $size => $harga) {
            $sizeModel = Size::where('nama', $size)->first();

            SizePrice::create([
                'category_id' => $smoothies->id,
                'size_id' => $sizeModel->id,
                'harga' => $harga,
            ]);
        }
    }
}
