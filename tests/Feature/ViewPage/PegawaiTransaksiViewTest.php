<?php

namespace Tests\Feature\Pegawai;

use Tests\TestCase;
use App\Models\User;
use App\Models\Category;
use App\Models\Business;
use Illuminate\Foundation\Testing\RefreshDatabase;

class PegawaiTransaksiViewTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_requires_authentication_to_access_transaksi_page()
    {
        $response = $this->get('/pegawai/transaksi');

        $response->assertRedirect('/login'); // Sesuaikan jika route login beda
    }

    /** @test */
    public function it_shows_transaksi_page_with_correct_categories()
    {
        // Business
        $business = Business::factory()->create();

        // Pegawai
        $pegawai = User::factory()->create([
            'role' => 'pegawai',
            'is_verified' => true,
            'id_business' => $business->id,
        ]);

        // 3 kategori milik business ini
        $categories = Category::factory()->count(3)->create([
            'business_id' => $business->id,
        ]);

        // Login as pegawai
        $response = $this->actingAs($pegawai)
                         ->get(route('pegawai.transaksi.index'));

        // Assertions
        $response->assertStatus(200)
                 ->assertViewIs('pegawai.transaksi.index')
                 ->assertViewHas('categories', function ($cats) use ($categories) {
                     return $cats->pluck('id')->sort()->values()->all() ===
                            $categories->pluck('id')->sort()->values()->all();
                 });
    }
}
