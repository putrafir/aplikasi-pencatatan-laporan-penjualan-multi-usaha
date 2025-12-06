<?php

namespace Tests\Feature\ManageMenu;

use Tests\TestCase;
use App\Models\Menu;
use App\Models\Category;
use App\Models\Business;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithoutMiddleware;

class DeleteMenuTest extends TestCase
{
    use RefreshDatabase, WithoutMiddleware;

    /** @test */
    public function dapat_menghapus_menu_tanpa_middleware()
    {
        // Buat business
        $business = Business::factory()->create();

        // Buat kategori
        $category = Category::factory()->create([
            'business_id' => $business->id
        ]);

        // Buat menu
        $menu = Menu::factory()->create([
            'business_id' => $business->id,
            'kategori_id' => $category->id,
            'foto' => 'img/illustrations/no-image.png'
        ]);

        // Eksekusi DELETE tanpa login / tanpa middleware
        $response = $this->delete(route('admin.menus.destroy', $menu->id));

        // Pastikan redirect dan pesan sukses
        $response->assertRedirect();
        $response->assertSessionHas('success', 'Menu dan fotonya berhasil dihapus.');

        // Pastikan data benar-benar terhapus dari database
        $this->assertDatabaseMissing('menus', [
            'id' => $menu->id
        ]);
    }
}
