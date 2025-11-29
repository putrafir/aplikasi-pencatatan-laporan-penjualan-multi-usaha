<?php

namespace Database\Factories;

use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Category>
 */
class CategoryFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model = Category::class;

    public function definition(): array
    {
        // daftar kategori berdasarkan seeder
        $categories = [
            ['nama' => 'Smoothies', 'business_id' => 2],
            ['nama' => 'Juice', 'business_id' => 2],
            ['nama' => 'Other', 'business_id' => 2],
            ['nama' => 'Pisgor', 'business_id' => 1],
            ['nama' => 'Cemilans', 'business_id' => 1],
            ['nama' => 'Original', 'business_id' => 2],
            ['nama' => 'Hotang', 'business_id' => 2],
        ];

        $category = $this->faker->randomElement($categories);

        return [
            'nama' => $category['nama'],
            'business_id' => $category['business_id'],
        ];
    }
}
