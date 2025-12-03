<?php

namespace Tests\Feature\ManageStock;

use Tests\TestCase;
use App\Models\User;
use App\Models\Stock;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithoutMiddleware;

class EditStockTest extends TestCase
{
    use RefreshDatabase,WithoutMiddleware;

    /** @test */
    public function tc01_update_valid_data_berhasil()
    {

        $stock = Stock::factory()->create([
            'nama' => 'Beras',
            'satuan' => 'kg'
        ]);

        $response = $this->put(route('admin.stock.update', $stock->id), [
            'nama' => 'Gula Pasir',
            'satuan' => 'kg',
        ]);

        $response->assertRedirect();
        $response->assertSessionHas('success', 'Data stok berhasil diperbarui.');

        $this->assertDatabaseHas('stock', [
            'id' => $stock->id,
            'nama' => 'Gula Pasir',
            'satuan' => 'kg'
        ]);
    }

    /** @test */
    public function tc02_update_gagal_nama_kosong()
    {

        $stock = Stock::factory()->create();

        $response = $this->put(route('admin.stock.update', $stock->id), [
            'nama' => '',
            'satuan' => 'kg',
        ]);

        $response->assertSessionHasErrors(['nama']);
    }

    /** @test */
    public function tc03_update_gagal_nama_bukan_string()
    {

        $stock = Stock::factory()->create();

        $response = $this->put(route('admin.stock.update', $stock->id), [
            'nama' => 12345,
            'satuan' => 'kg',
        ]);

        $response->assertSessionHasErrors(['nama']);
    }

    /** @test */
    public function tc04_update_gagal_satuan_kosong()
    {

        $stock = Stock::factory()->create();

        $response = $this->put(route('admin.stock.update', $stock->id), [
            'nama' => 'Minyak Goreng',
            'satuan' => '',
        ]);

        $response->assertSessionHasErrors(['satuan']);
    }

    /** @test */
    public function tc05_update_gagal_satuan_bukan_string()
    {
        $stock = Stock::factory()->create();

        $response = $this->put(route('admin.stock.update', $stock->id), [
            'nama' => 'Minyak Goreng',
            'satuan' => 500,
        ]);

        $response->assertSessionHasErrors(['satuan']);
    }
}
