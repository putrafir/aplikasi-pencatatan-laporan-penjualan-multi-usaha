<?php

namespace Database\Seeders;

use App\Models\Business;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class BusinessSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $businesses = [
            ['business_name' => 'PISGOR CRUNCHY'],
            ['business_name' => 'MISS SMOOTHIES']
        ];

        Business::insert($businesses);
    }
}
