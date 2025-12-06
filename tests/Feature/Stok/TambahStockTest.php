<?php

namespace Tests\Feature\ManageStock;

use App\Models\Business;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Tests\TestCase;

class TambahStockTest extends TestCase
{
    use RefreshDatabase, WithoutMiddleware;

    /** TC1 — Semua field valid */
    public function test_tc1_semua_field_valid_dan_data_tersimpan()
    {
        $business = Business::factory()->create();

        $response = $this->post('/admin/stock/add', [
            'nama' => 'Gula Pasir',
            'jumlah_stok' => 10,
            'harga' => 15000,
            'business_id' => $business->id,
            'satuan' => 'Kg'
        ]);

        $response->assertRedirect();
        $this->assertDatabaseHas('stock', [
            'nama' => 'Gula Pasir',
            'jumlah_stok' => 10,
            'harga' => 15000,
            'business_id' => $business->id,
        ]);
    }

    /** TC2 — jumlah_stok null */
    public function test_tc2_jumlah_stok_null_tersimpan_dengan_default_0()
    {
        $business = Business::factory()->create();

        $response = $this->post('/admin/stock/add', [
            'nama' => 'Gula',
            'jumlah_stok' => null,
            'harga' => 10000,
            'business_id' => $business->id,
            'satuan' => 'Kg'
        ]);

        $response->assertRedirect();
        $this->assertDatabaseHas('stock', [
            'nama' => 'Gula',
            'jumlah_stok' => 0,  // default
        ]);
    }

    /** TC3 — harga null */
    public function test_tc3_harga_null_data_tersimpan()
    {
        $business = Business::factory()->create();

        $response = $this->post('/admin/stock/add', [
            'nama' => 'Beras',
            'jumlah_stok' => 5,
            'harga' => null,
            'business_id' => $business->id,
            'satuan' => 'Kg'
        ]);

        $response->assertRedirect();
        $this->assertDatabaseHas('stock', [
            'nama' => 'Beras',
            'harga' => null,
        ]);
    }

    /** TC4 — nama kosong */
    public function test_tc4_nama_kosong_validasi_gagal()
    {
        $business = Business::factory()->create();

        $response = $this->post('/admin/stock/add', [
            'nama' => '',
            'business_id' => $business->id,
            'satuan' => 'Kg'
        ]);

        $response->assertSessionHasErrors('nama');
    }

    /** TC5 — nama >255 karakter */
    public function test_tc5_nama_melebihi_255_karakter_validasi_gagal()
    {
        $business = Business::factory()->create();

        $longName = str_repeat('A', 300);

        $response = $this->post('/admin/stock/add', [
            'nama' => $longName,
            'business_id' => $business->id,
            'satuan' => 'Kg'
        ]);

        $response->assertSessionHasErrors('nama');
    }

    /** TC6 — jumlah_stok bukan integer */
    public function test_tc6_jumlah_stok_bukan_integer_validasi_gagal()
    {
        $business = Business::factory()->create();

        $response = $this->post('/admin/stock/add', [
            'nama' => 'Minyak',
            'jumlah_stok' => 'sepuluh',
            'business_id' => $business->id,
            'satuan' => 'L'
        ]);

        $response->assertSessionHasErrors('jumlah_stok');
    }

    /** TC7 — harga bukan integer */
    public function test_tc7_harga_bukan_integer_validasi_gagal()
    {
        $business = Business::factory()->create();

        $response = $this->post('/admin/stock/add', [
            'nama' => 'Garam',
            'harga' => 'murah',
            'business_id' => $business->id,
            'satuan' => 'Gr'
        ]);

        $response->assertSessionHasErrors('harga');
    }

    /** TC8 — business_id tidak ditemukan */
    public function test_tc8_business_id_tidak_ditemukan_validasi_gagal()
    {

        $response = $this->post('/admin/stock/add', [
            'nama' => 'Telur',
            'business_id' => 9999,
            'satuan' => 'Pcs'
        ]);

        $response->assertSessionHasErrors('business_id');
    }

    /** TC9 — satuan kosong atau lebih dari 50 karakter */
    public function test_tc9_satuan_kosong_validasi_gagal()
    {
        $business = Business::factory()->create();

        $response = $this->post('/admin/stock/add', [
            'nama' => 'Ayam',
            'business_id' => $business->id,
            'satuan' => ''
        ]);

        $response->assertSessionHasErrors('satuan');
    }

    public function test_tc9_satuan_melebihi_50_karakter_validasi_gagal()
    {
        $business = Business::factory()->create();

        $longSatuan = str_repeat('X', 80);

        $response = $this->post('/admin/stock/add', [
            'nama' => 'Ayam',
            'business_id' => $business->id,
            'satuan' => $longSatuan
        ]);

        $response->assertSessionHasErrors('satuan');
    }
}
