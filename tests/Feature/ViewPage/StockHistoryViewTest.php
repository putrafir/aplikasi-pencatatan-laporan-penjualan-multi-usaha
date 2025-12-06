<?php

namespace Tests\Feature\ViewPage;

use Tests\TestCase;
use App\Models\User;
use App\Models\Stock;
use App\Models\Business;
use App\Models\RiwayatStok;
use Illuminate\Foundation\Testing\RefreshDatabase;

class StockHistoryViewTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_can_access_stock_history_page()
    {
        // Arrange
        $owner = User::factory()->create([
            'role' => 'owner',
            'is_verified' => true,
        ]);

        $business = Business::factory()->create();
        $user = User::factory()->create();

        $stock = Stock::factory()->create([
            'business_id' => $business->id
        ]);

        RiwayatStok::factory()->create([
            'stock_id' => $stock->id,
            'user_id' => $user->id,
        ]);

        $response = $this->actingAs($owner)->get('/admin/stock-history');

        $response->assertStatus(200);
        $response->assertViewIs('admin.manage-stock.stok-history');
        $response->assertViewHas('riwayatStok');
    }

    /** @test */
    public function it_filters_stock_history_by_business_id()
    {
        // Arrange
        $owner = User::factory()->create([
            'role' => 'owner',
            'is_verified' => true,
        ]);

        $businessA = Business::factory()->create();
        $businessB = Business::factory()->create();

        $user = User::factory()->create();

        // Record belonging to business A
        $stockA = Stock::factory()->create(['business_id' => $businessA->id]);
        RiwayatStok::factory()->create([
            'stock_id' => $stockA->id,
            'user_id' => $user->id,
        ]);

        // Record belonging to business B
        $stockB = Stock::factory()->create(['business_id' => $businessB->id]);
        RiwayatStok::factory()->create([
            'stock_id' => $stockB->id,
            'user_id' => $user->id,
        ]);

        $response = $this->actingAs($owner)->get('/admin/stock-history?business_id=' . $businessA->id);

        $response->assertStatus(200);
        $response->assertViewHas('riwayatStok', function ($riwayat) use ($businessA) {
            return $riwayat->every(function ($item) use ($businessA) {
                return $item['business_name'] === $businessA->name;
            });
        });
    }

    /** @test */
    public function it_shows_error_if_business_not_found()
    {
        // Arrange
        $owner = User::factory()->create([
            'role' => 'owner',
            'is_verified' => true,
        ]);

        $response = $this->actingAs($owner)->get('/admin/stock-history?business_id=999');

        $response->assertStatus(302);
        $response->assertSessionHas('error', 'Data bisnis tidak ditemukan.');
    }

    /** @test */
    public function it_maps_and_formats_stock_history_data_correctly()
    {
        // Arrange
        $owner = User::factory()->create([
            'role' => 'owner',
            'is_verified' => true,
        ]);

        $business = Business::factory()->create();
        $user = User::factory()->create();

        $stock = Stock::factory()->create([
            'business_id' => $business->id,
            'nama' => 'Produk Tes'
        ]);

        $log = RiwayatStok::factory()->create([
            'stock_id' => $stock->id,
            'user_id' => $user->id,
            'status' => 'masuk',
            'jumlah' => 50,
        ]);

        $response = $this->actingAs($owner)->get('/admin/stock-history');

        $response->assertViewHas('riwayatStok', function ($riwayat) use ($log, $stock, $user, $business) {
            $first = $riwayat->first();

            return
                $first['nama'] === $stock->nama &&
                $first['business_name'] === $business->name &&
                $first['user_name'] === $user->name &&
                $first['status'] === 'masuk' &&
                $first['jumlah'] === 50 &&
                $first['created_at'] === $log->created_at->format('Y-m-d H:i');
        });
    }

    /** @test */
    public function it_requires_authentication_to_access_stock_history_page()
    {
        $response = $this->get('/admin/stock-history');

        $response->assertRedirect('/login'); // atau route login lain jika beda
    }
}
