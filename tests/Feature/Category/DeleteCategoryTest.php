<?php

namespace Tests\Feature\ManageCategory;

use App\Models\Business;
use App\Models\Category;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;

class DeleteCategoryTest extends TestCase
{
    use RefreshDatabase,WithoutMiddleware;

    /** @test */
    public function dapat_menghapus_kategori_tanpa_middleware()
    {
        // Buat dummy business
        $business = Business::factory()->create();

        // Buat kategori
        $category = Category::factory()->create([
            'business_id' => $business->id,
            'nama' => 'Minuman'
        ]);

        // Jalankan DELETE tanpa middleware auth / owner
        $response = $this->delete(route('admin.kategori.destroy', $category->id));

        // Pastikan redirect dan pesan sukses
        $response->assertRedirect();
        $response->assertSessionHas('success', 'Menu berhasil dihapus.');

        // Pastikan kategori benar-benar terhapus
        $this->assertDatabaseMissing('categories', [
            'id' => $category->id
        ]);
    }
}
