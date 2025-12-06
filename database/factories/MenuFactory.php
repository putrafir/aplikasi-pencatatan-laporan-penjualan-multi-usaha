<?php

namespace Database\Factories;

use App\Models\Business;
use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;

class MenuFactory extends Factory
{
    public function definition(): array
    {
        return [
            'nama' => $this->faker->words(2, true),
            'deskripsi' => $this->faker->sentence(6),
            'harga' => $this->faker->numberBetween(10000, 25000),

            // Relasi
            'kategori_id' => Category::factory(),
            'business_id' => Business::factory(),

            // Supaya tidak perlu file saat testing
            'foto' => 'img/illustrations/no-image.png',
        ];
    }
}
