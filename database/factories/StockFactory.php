<?php

namespace Database\Factories;

use App\Models\Stock;
use App\Models\Business;
use Illuminate\Database\Eloquent\Factories\Factory;

class StockFactory extends Factory
{
    protected $model = Stock::class;

    public function definition()
    {
        return [
            'nama' => $this->faker->word,
            'jumlah_stok' => $this->faker->numberBetween(1, 100),
            'harga' => $this->faker->numberBetween(1000, 50000),
            'satuan' => 'kg',
            'business_id' => Business::factory(),
        ];
    }
}
