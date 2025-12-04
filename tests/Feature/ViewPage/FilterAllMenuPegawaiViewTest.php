<?php

namespace Tests\Feature\Pegawai;

use Tests\TestCase;
use App\Models\Menu;
use App\Models\User;
use App\Models\Business;
use App\Models\Category;
use App\Models\Transaksi;
use Illuminate\Support\Facades\DB;
use Illuminate\Foundation\Testing\RefreshDatabase;

class GetAllMenusTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_returns_menus_with_correct_best_seller_flag()
    {
        // ========================
        // SETUP BUSINESS & USER
        // ========================
        $business = Business::factory()->create();

        $pegawai = User::factory()->create([
            'role' => 'pegawai',
            'is_verified' => true,
            'id_business' => $business->id,
        ]);

        // ========================
        // SETUP CATEGORY & MENUS
        // ========================
        $category = Category::factory()->create([
            'business_id' => $business->id,
        ]);

        $menuA = Menu::factory()->create([
            'kategori_id' => $category->id,
            'business_id' => $business->id,
        ]);

        $menuB = Menu::factory()->create([
            'kategori_id' => $category->id,
            'business_id' => $business->id,
        ]);

        $menuC = Menu::factory()->create([
            'kategori_id' => $category->id,
            'business_id' => $business->id,
        ]);

        $menuD = Menu::factory()->create([
            'kategori_id' => $category->id,
            'business_id' => $business->id,
        ]);

        // ========================
        // BUAT TRANSAKSI DALAM 7 HARI
        // ========================
        // MenuA = 10 kali (best seller)
        // MenuB = 5 kali
        // MenuC = 1 kali

        Transaksi::factory()->create([
            'business_id' => $business->id,
            'user_id' => $pegawai->id,
            'details' => json_encode([
                ['menu_id' => $menuA->id, 'jumlah' => 10, 'harga' => 10000],
                ['menu_id' => $menuB->id, 'jumlah' => 5,  'harga' => 15000],
                ['menu_id' => $menuC->id, 'jumlah' => 1,  'harga' => 20000],
                ['menu_id' => $menuD->id, 'jumlah' => 3,  'harga' => 20000],
            ]),
            'created_at' => now(),
        ]);

        // ========================
        // HIT ENDPOINT
        // ========================
        $response = $this->actingAs($pegawai)->get('/pegawai/get-all-menus');

        $response->assertStatus(200);

        $response->assertJsonStructure([
            'menus' => [
                '*' => [
                    'id',
                    'nama',
                    'deskripsi',
                    'harga',
                    'foto',
                    'business_id',
                    'is_best_seller',
                ]
            ]
        ]);

        // Ambil semua menu dari JSON
        $menus = collect($response->json('menus'));

        // ========================
        // CEK BEST SELLER
        // ========================
        // menuA harus best seller
        $this->assertTrue(
            $menus->firstWhere('id', $menuA->id)['is_best_seller']
        );

        $this->assertTrue(
            $menus->firstWhere('id', $menuB->id)['is_best_seller']
        );

        $this->assertFalse(
            $menus->firstWhere('id', $menuC->id)['is_best_seller']
        );

        $this->assertTrue(
            $menus->firstWhere('id', $menuD->id)['is_best_seller']
        );
    }

    /** @test */
    public function guest_cannot_access_detail_user_page()
    {
        $response = $this->get('/pegawai/get-all-menus');

        $response->assertRedirect('/login');
    }
}
