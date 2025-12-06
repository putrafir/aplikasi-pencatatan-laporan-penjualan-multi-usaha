<?php

namespace Database\Factories;

use App\Models\Business;
use Illuminate\Database\Eloquent\Factories\Factory;


/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Business>
 */
class BusinessFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model = Business::class;
    public function definition(): array
    {
        return [
            'name' => $this->faker->unique()->randomElement([
                'Pisgor',
                'Miss',
            ]),

        ];
    }
}
