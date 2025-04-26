<?php

namespace Database\Seeders;

use App\Models\SuperCategory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SuperCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        SuperCategory::insert([
            ['nama' => 'Miss Smoothies', 'business_id' => 2],
            ['nama' => 'Miss Hotang', 'business_id' => 2],
        ]);
    }
}
