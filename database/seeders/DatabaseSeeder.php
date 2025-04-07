<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Menu;
use App\Models\MenuSize;
use App\Models\Size;
use App\Models\SizePrice;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        $this->call([
            BusinessSeeder::class,
            PegawaiSeeder::class,
        ]);

        User::factory()->create([
            'name' => 'Nita Nina Wibawa',
            'email' => 'nita@gmail.com',
            'password' => 'nita1234',
            'role' => 'owner',
            'is_verified' => true,
        ]);

        // $categories = ['Smoothies', 'Juice', 'Other'];

        // foreach ($categories as $category) {
        //     Category::create(['nama' => $category]);
        // }

        $this->call([
            CategorySeeder::class,
            MenuSeeder::class,
            SizeSeeder::class,
            SizePriceSeeder::class,
        ]);
    }
}
