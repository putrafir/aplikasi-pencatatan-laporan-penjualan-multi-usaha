<?php

namespace Tests\Feature\ViewPage;

use Tests\TestCase;
use App\Models\User;
use App\Models\Business;
use App\Models\Transaksi;
use Illuminate\Foundation\Testing\RefreshDatabase;

class RiwayatTransaksiPegawaiViewTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_requires_authentication()
    {
        $response = $this->get(route('pegawai.riwayat-transaksi.index'));

        $response->assertRedirect(route('login'));
    }

    /** @test */
    public function it_shows_only_today_transactions_for_logged_in_user()
    {
        // Setup: business
        $business = Business::factory()->create();

        // Setup: user pegawai
        $pegawai = User::factory()->create([
            'role' => 'pegawai',
            'is_verified' => true,
            'id_business' => $business->id,
        ]);

        // Transaksi hari ini (harus muncul)
        $t1 = Transaksi::factory()->create([
            'user_id' => $pegawai->id,
            'business_id' => $business->id,
            'total_bayar' => 20000,
            'created_at' => now(),
        ]);

        $t2 = Transaksi::factory()->create([
            'user_id' => $pegawai->id,
            'business_id' => $business->id,
            'total_bayar' => 35000,
            'created_at' => now(),
        ]);

        // Transaksi kemarin (tidak boleh muncul)
        Transaksi::factory()->create([
            'user_id' => $pegawai->id,
            'business_id' => $business->id,
            'total_bayar' => 99999,
            'created_at' => now()->subDay(),
        ]);

        // Total expected
        $expectedTotal = 20000 + 35000;

        // Act
        $response = $this->actingAs($pegawai)
                         ->get(route('pegawai.riwayat-transaksi.index'));

        // Assert View
        $response->assertStatus(200)
                 ->assertViewIs('pegawai.riwayat-transaksi.index')
                 ->assertViewHas('transaksis', function ($data) use ($t1, $t2) {
                     // Cek hanya transaksi hari ini yang muncul
                     return $data->pluck('id')->sort()->values()->all() ===
                            collect([$t1->id, $t2->id])->sort()->values()->all();
                 })
                 ->assertViewHas('totalHariIni', $expectedTotal);
    }
}
