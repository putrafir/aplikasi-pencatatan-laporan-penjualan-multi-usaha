<?php

namespace Tests\Feature\Pegawai;

use Tests\TestCase;
use App\Models\User;
use App\Models\Business;
use App\Models\Stock;
use App\Models\Transaksi;
use Illuminate\Foundation\Testing\RefreshDatabase;

class PegawaiUpdateStokViewTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_requires_authentication()
    {
        $response = $this->get(route('pegawai.update_stoke'));

        $response->assertRedirect(route('login'));
    }

    /** @test */
    public function it_shows_update_stok_page_with_correct_data()
    {
        // Setup business
        $business = Business::factory()->create();

        // Setup user
        $pegawai = User::factory()->create([
            'role' => 'pegawai',
            'is_verified' => true,
            'id_business' => $business->id,
        ]);

        // Setup stocks
        $stock1 = Stock::factory()->create([
            'business_id' => $business->id,
            'stok_awal'   => 10,
            'stok_akhir'  => null, // belum update
        ]);

        $stock2 = Stock::factory()->create([
            'business_id' => $business->id,
            'stok_awal'   => 20,
            'stok_akhir'  => 15, // sudah update
        ]);

        // Setup transaksi hari ini
        $t1 = Transaksi::factory()->create([
            'business_id' => $business->id,
            'user_id'     => $pegawai->id,
            'total_bayar' => 10000,
            'created_at'  => now(),
        ]);

        // Act
        $response = $this->actingAs($pegawai)
                         ->get(route('pegawai.update_stoke'));

        // Assert
        $response->assertStatus(200)
                 ->assertViewIs('pegawai.UpdateStok')
                 ->assertViewHas('user', $pegawai)
                 ->assertViewHas('business', $business)
                 ->assertViewHas('stocks', function ($data) use ($stock1, $stock2) {
                     return $data->count() === 2;
                 })
                 ->assertViewHas('transaksi', function ($data) use ($t1) {
                     return $data->count() === 1 && $data->first()->id === $t1->id;
                 })
                 ->assertViewHas('alreadyUpdated', true); // karena stock2 punya stok_akhir != null
    }

    /** @test */
    public function it_sets_alreadyUpdated_false_if_no_stock_has_stok_akhir()
    {
        // Setup business
        $business = Business::factory()->create();

        // Setup user
        $pegawai = User::factory()->create([
            'role' => 'pegawai',
            'is_verified' => true,
            'id_business' => $business->id,
        ]);

        // Semua stok belum update
        Stock::factory()->create([
            'business_id' => $business->id,
            'stok_awal'   => 10,
            'stok_akhir'  => null,
        ]);

        Stock::factory()->create([
            'business_id' => $business->id,
            'stok_awal'   => 25,
            'stok_akhir'  => null,
        ]);

        // Tidak perlu transaksi untuk test ini

        // Act
        $response = $this->actingAs($pegawai)
                         ->get(route('pegawai.update_stoke'));

        // Assert
        $response->assertStatus(200)
                 ->assertViewHas('alreadyUpdated', false);
    }
}
