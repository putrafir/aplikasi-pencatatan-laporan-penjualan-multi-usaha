<?php

use App\Models\Business;

test('dapat mengedit bisnis', function () {

    $business = Business::factory()->create([
        'name' => 'Toko Lama',
        'lokasi' => 'Jalan Lama No. 10',
    ]);

    $response = $this->withoutMiddleware()->put(route('admin.kelola-bisnis.update', $business->id), [
        'name' => 'Toko Updated',
        'lokasi' => 'Jalan Updated No. 20',
    ]);

  

    // Pastikan redirect sukses
    $response->assertRedirect();

    // Pastikan pesan sukses ada di session
    $response->assertSessionHas('success');

    // Pastikan data masuk database
    $this->assertDatabaseHas('business', [
        'name' => 'Toko Updated',
        'lokasi' => 'Jalan Updated No. 20',
    ]);
});

test('gagal mengedit bisnis tanpa nama', function () {
    $business = Business::factory()->create([
        'name' => 'Toko Lama',
        'lokasi' => 'Jalan Lama No. 10',
    ]);

    $response = $this->withoutMiddleware()->put(route('admin.kelola-bisnis.update', $business->id), [
        'name' => '',
        'lokasi' => 'Jalan Updated No. 20',
    ]);

    // Pastikan ada error validasi
    $response->assertSessionHasErrors('name');

    // Pastikan data tidak berubah di database
    $this->assertDatabaseHas('business', [
        'name' => 'Toko Lama',
        'lokasi' => 'Jalan Lama No. 10',
    ]);
});

test('gagal mengedit bisnis dengan nama terlalu panjang', function () {
    $business = Business::factory()->create([
        'name' => 'Toko Lama',
        'lokasi' => 'Jalan Lama No. 10',
    ]);

    $longName = str_repeat('A', 256); // 256 karakter

    $response = $this->withoutMiddleware()->put(route('admin.kelola-bisnis.update', $business->id), [
        'name' => $longName,
        'lokasi' => 'Jalan Updated No. 20',
    ]);

    // Pastikan ada error validasi
    $response->assertSessionHasErrors('name');

    // Pastikan data tidak berubah di database
    $this->assertDatabaseHas('business', [
        'name' => 'Toko Lama',
        'lokasi' => 'Jalan Lama No. 10',
    ]);
});

test('gagal mengedit bisnis tanpa lokasi', function () {
    $business = Business::factory()->create([
        'name' => 'Toko Lama',
        'lokasi' => 'Jalan Lama No. 10',
    ]);

    $response = $this->withoutMiddleware()->put(route('admin.kelola-bisnis.update', $business->id), [
        'name' => 'Toko Updated',
        'lokasi' => '',
    ]);

    // Pastikan ada error validasi
    $response->assertSessionHasErrors('lokasi');

    // Pastikan data tidak berubah di database
    $this->assertDatabaseHas('business', [
        'name' => 'Toko Lama',
        'lokasi' => 'Jalan Lama No. 10',
    ]);
});





