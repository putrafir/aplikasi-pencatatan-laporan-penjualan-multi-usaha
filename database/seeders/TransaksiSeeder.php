<?php

namespace Database\Seeders;

use App\Models\Business;
use App\Models\Transaksi;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TransaksiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = User::where('id', '!=', 3)->get();
        $businesses = Business::all();

        // if ($users->count() === 0 || $businesses->count() === 0) {
        //     $this->command->warn('⚠️ Harap seed dulu User dan Business sebelum TransaksiSeeder.');
        //     return;
        // }

        foreach ($businesses as $business) {
            // Buat transaksi 7 hari terakhir
            for ($i = 0; $i < 7; $i++) {
                $totalBayar = rand(50000, 500000);
                $uangDibayarkan = $totalBayar + rand(0, 20000);
                $kembalian = $uangDibayarkan - $totalBayar;

                Transaksi::create([
                    'user_id' => $users->random()->id,
                    'business_id' => $business->id,
                    'total_bayar' => $totalBayar,
                    'uang_dibayarkan' => $uangDibayarkan,
                    'kembalian' => $kembalian,
                    'details' => json_encode([
                        [
                            'menu' => 'Nasi Goreng',
                            'jumlah' => 2,
                            'harga' => 20000,
                            'subtotal' => 40000,
                        ],
                        [
                            'menu' => 'Es Teh',
                            'jumlah' => 1,
                            'harga' => 5000,
                            'subtotal' => 5000,
                        ],
                    ]),
                    // 'created_at' => Carbon::yesterday(),
                    // 'updated_at' => Carbon::yesterday(),
                    'created_at' => Carbon::now()->subDays($i),
                    'updated_at' => Carbon::now()->subDays($i),

                ]);
            }
        }
    }
}
