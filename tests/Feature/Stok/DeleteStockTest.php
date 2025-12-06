<?php

namespace Tests\Feature\ManageStock;

use Tests\TestCase;
use App\Models\Stock;
use App\Models\Business;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithoutMiddleware;

class DeleteStockTest extends TestCase
{
    use RefreshDatabase, WithoutMiddleware;

    /** @test */
    public function user_can_delete_stock_successfully()
    {
        // Buat data business
        $business = Business::factory()->create();

        // Buat stok
        $stock = Stock::factory()->create([
            'business_id' => $business->id
        ]);

        // Eksekusi DELETE tanpa middleware
        $response = $this->delete(route('admin.stock.destroy', $stock->id));

        // Pastikan redirect dan pesan sukses
        $response->assertRedirect();
        $response->assertSessionHas('success', 'Data stok berhasil dihapus');

        // Pastikan stok benar-benar hilang dari DB
        $this->assertDatabaseMissing('stock', [
            'id' => $stock->id
        ]);
    }
}
