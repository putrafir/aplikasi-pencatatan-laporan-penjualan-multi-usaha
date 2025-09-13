<?php

namespace Database\Seeders;

use App\Models\Stock;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class StockSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create('id_ID');

        $satuan = ['pcs', 'bungkus', 'kantong', 'cup'];
        $namaStock = ['cup', 'susu', 'buah', 'sedotan', 'kantong', 'selai coklat'];

        foreach (range(1, 20) as $index) {
            Stock::create([
                'nama'        => $faker->randomElement($namaStock),
                'business_id' => $faker->numberBetween(1, 2),
                'jumlah_stok' => $faker->numberBetween(0, 100),
                'satuan'      => $faker->randomElement($satuan),
                'harga'       => $faker->numberBetween(500, 50000),
            ]);
        }
    }
}
