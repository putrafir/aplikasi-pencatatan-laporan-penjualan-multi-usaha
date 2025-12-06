<?php

namespace Database\Factories;

use App\Models\Business;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class TransaksiFactory extends Factory
{
    public function definition()
    {
        return [
            'user_id' => \App\Models\User::factory(),
            'business_id' => \App\Models\Business::factory(),
            'total_bayar' => fake()->numberBetween(10000, 100000),
            'uang_dibayarkan' => fake()->numberBetween(10000, 100000),
            'kembalian' => fake()->numberBetween(0, 50000),
            'details' => json_encode([
                [
                    'menu_id' => 1,
                    'jumlah' => 2,
                    'harga' => 15000
                ]
            ]),
        ];
    }
}
