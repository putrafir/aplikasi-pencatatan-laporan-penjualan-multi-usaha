<?php

namespace Tests\Feature\Pegawai;

use Tests\TestCase;
use App\Models\User;
use App\Models\Menu;
use App\Models\Keranjang;
use App\Models\Business;
use Illuminate\Foundation\Testing\RefreshDatabase;

class KeranjangViewTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_requires_authentication_to_access_cart_page()
    {
        $response = $this->get(route('pegawai.keranjang'));

        $response->assertRedirect(route('login'));
    }

    /** @test */
    public function it_shows_cart_page_with_correct_data()
    {
        // Setup business
        $business = Business::factory()->create();

        // User pegawai
        $pegawai = User::factory()->create([
            'role' => 'pegawai',
            'is_verified' => true,
            'id_business' => $business->id,
        ]);

        // Menu
        $menu1 = Menu::factory()->create();
        $menu2 = Menu::factory()->create();

        // Keranjang milik business user
        $keranjang1 = Keranjang::factory()->create([
            'menu_id' => $menu1->id,
            'business_id' => $business->id,
            'total_harga' => 15000,
        ]);

        $keranjang2 = Keranjang::factory()->create([
            'menu_id' => $menu2->id,
            'business_id' => $business->id,
            'total_harga' => 25000,
        ]);

        // Total expected
        $expectedTotal = 15000 + 25000;

        // Act
        $response = $this->actingAs($pegawai)
                         ->get(route('pegawai.keranjang'));

        // Assert
        $response->assertStatus(200)
                 ->assertViewIs('pegawai.keranjang.index')
                 ->assertViewHas('keranjangs', function ($data) use ($keranjang1, $keranjang2) {
                     return $data->pluck('id')->sort()->values()->all() ===
                            collect([$keranjang1->id, $keranjang2->id])->sort()->values()->all();
                 })
                 ->assertViewHas('totalBayar', $expectedTotal);
    }
}
