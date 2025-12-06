<?php

namespace Tests\Feature\ViewPage;

use Tests\TestCase;
use App\Models\User;
use App\Models\Business;
use App\Models\Transaksi;
use App\Models\Stock;
use App\Models\StockLog;
use Illuminate\Foundation\Testing\RefreshDatabase;

class LaporanOwnerViewTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_can_access_laporan_page()
    {
        // Arrange
        $owner = User::factory()->create([
            'role' => 'owner',
            'is_verified' => true,
        ]);

        $business = Business::factory()->create();

        $response = $this->actingAs($owner)->get("/admin/laporan/" . $business->id);

        $response->assertStatus(200)
                 ->assertViewIs("admin.laporan.detailLaporan")
                 ->assertViewHas("business");
    }

    /** @test */
    public function it_filters_transactions_by_date_range()
    {
        // Arrange
        $owner = User::factory()->create([
            'role' => 'owner',
            'is_verified' => true,
        ]);
        
        $business = Business::factory()->create();

        // transaksi dalam rentang
        $t1 = Transaksi::factory()->create([
            'business_id' => $business->id,
            'created_at' => now()->subDays(1),
            'details' => json_encode([
                ['nama' => 'Kopi', 'jumlah' => 2, 'harga' => 10000]
            ]),
        ]);

        // transaksi luar rentang
        $t2 = Transaksi::factory()->create([
            'business_id' => $business->id,
            'created_at' => now()->subDays(10),
            'details' => json_encode([
                ['nama' => 'Teh', 'jumlah' => 1, 'harga' => 5000]
            ]),
        ]);

        $response = $this->actingAs($owner)->get("/admin/laporan/{$business->id}?start=" . now()->subDays(2)->toDateString() . "&end=" . now()->toDateString());

        $response->assertStatus(200);
        $response->assertViewHas("business", function($data) {
            return $data->transaksis->count() === 1;
        });
    }

    /** @test */
    public function it_filters_stock_logs_by_date_and_business()
    {
        // Arrange
        $owner = User::factory()->create([
            'role' => 'owner',
            'is_verified' => true,
        ]);

        $business = Business::factory()->create();

        $stock1 = Stock::factory()->create(['business_id' => $business->id]);
        $stock2 = Stock::factory()->create(['business_id' => $business->id]);

        // Dalam rentang
        $log1 = StockLog::factory()->create([
            'stock_id' => $stock1->id,
            'stok_keluar' => 5,
            'created_at' => now()->subDay(),
        ]);

        // Luar rentang
        $log2 = StockLog::factory()->create([
            'stock_id' => $stock2->id,
            'stok_keluar' => 3,
            'created_at' => now()->subDays(10),
        ]);

        $response = $this->actingAs($owner)->get("/admin/laporan/{$business->id}?start=" . now()->subDays(2)->toDateString() . "&end=" . now()->toDateString());

        $response->assertViewHas("stocks", function ($stocks) use ($log1) {
            return $stocks->contains('id', $log1->id) && $stocks->count() === 1;
        });
    }

    /** @test */
    public function it_groups_and_sums_transaction_items_correctly()
    {
        // Arrange
        $owner = User::factory()->create([
            'role' => 'owner',
            'is_verified' => true,
        ]);

        $business = Business::factory()->create();
        $user = User::factory()->create();
        $this->actingAs($user);

        Transaksi::factory()->create([
            'business_id' => $business->id,
            'details' => json_encode([
                ['nama' => 'Kopi', 'jumlah' => 2, 'harga' => 10000],
                ['nama' => 'Teh', 'jumlah' => 1, 'harga' => 5000],
            ]),
            'created_at' => now()
        ]);

        Transaksi::factory()->create([
            'business_id' => $business->id,
            'details' => json_encode([
                ['nama' => 'Kopi', 'jumlah' => 3, 'harga' => 10000],
            ]),
            'created_at' => now()
        ]);

        $response = $this->actingAs($owner)->get("/admin/laporan/{$business->id}");

        $response->assertViewHas("allItems", function ($items) {

            $kopi = $items->firstWhere('nama', 'Kopi');
            $teh = $items->firstWhere('nama', 'Teh');

            return
                $kopi['jumlah'] === 5 &&
                $kopi['total'] === 50000 &&
                $teh['jumlah'] === 1 &&
                $teh['total'] === 5000;
        });
    }

    /** @test */
    public function redirect_to_login_if_not_logged_in()
    {
        // Arrange: Buat business dengan relasi
        $business = Business::factory()->create();

        $response = $this->get("/admin/laporan/" . $business->id);

        $response->assertRedirect(route('login'));
    }
}
