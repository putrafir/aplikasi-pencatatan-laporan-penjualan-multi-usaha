<?php

namespace Tests\Feature\KelolaBisnis;

use App\Models\Business;
use App\Models\User;
use App\Models\Menu;
use App\Models\Stock;
use App\Models\Category;
use App\Models\Transaksi;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;

class DeleteBusinessTest extends TestCase
{
    use RefreshDatabase,WithoutMiddleware;

    /** @test */
    public function owner_dapat_menghapus_jenis_usaha_beserta_relasi()
    {
        // Membuat business + relasi
        $business = Business::factory()->create();

        $user = User::factory()->create(['id_business' => $business->id]);
        $menu = Menu::factory()->create(['business_id' => $business->id]);
        $stock = Stock::factory()->create(['business_id' => $business->id]);
        $category = Category::factory()->create(['business_id' => $business->id]);
        $transaksi = Transaksi::factory()->create(['business_id' => $business->id]);

        // Eksekusi DELETE
        $response = $this->delete(route('admin.kelola-bisnis.destroy', $business->id));

        // Redirect dan pesan berhasil
        $response->assertRedirect();
        $response->assertSessionHas('success', 'Bisnis berhasil dihapus.');

        // Pastikan business terhapus
        $this->assertDatabaseMissing('business', ['id' => $business->id]);

        // Pastikan semua relasi juga terhapus
        $this->assertDatabaseMissing('users', ['id' => $user->id]);
        $this->assertDatabaseMissing('menus', ['id' => $menu->id]);
        $this->assertDatabaseMissing('stock', ['id' => $stock->id]);
        $this->assertDatabaseMissing('categories', ['id' => $category->id]);
        $this->assertDatabaseMissing('transaksis', ['id' => $transaksi->id]);
    }
}

