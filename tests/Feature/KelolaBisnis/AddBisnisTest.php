<?php

test('dapat menambah bisnis baru', function () {
    $response = $this->withoutMiddleware()->post(route('admin.kelola-bisnis.add'), [
        'name' => 'Toko Pisang Goreng',
        'lokasi' => 'Jalan Mawar No. 10',
    ]);

    // Pastikan redirect sukses
    $response->assertRedirect();

    // Pastikan pesan sukses ada di session
    $response->assertSessionHas('success');

    // Pastikan data masuk database
    $this->assertDatabaseHas('business', [
        'name' => 'Toko Pisang Goreng',
        'lokasi' => 'Jalan Mawar No. 10',
    ]);
});

test('gagal menambah bisnis tanpa nama', function () {
    $response = $this->withoutMiddleware()->post(route('admin.kelola-bisnis.add'), [
        'name' => '',
        'lokasi' => 'Jalan Mawar No. 10',
    ]);

    // Pastikan ada error validasi
    $response->assertSessionHasErrors('name');

    // Pastikan data tidak masuk database
    $this->assertDatabaseMissing('business', [
        'lokasi' => 'Jalan Mawar No. 10',
    ]);
});

test('gagal menambah bisnis tanpa lokasi', function () {
    $response = $this->withoutMiddleware()->post(route('admin.kelola-bisnis.add'), [
        'name' => 'Toko Pisang Goreng',
        'lokasi' => '',
    ]);

    // Pastikan ada error validasi
    $response->assertSessionHasErrors('lokasi');

    // Pastikan data tidak masuk database
    $this->assertDatabaseMissing('business', [
        'name' => 'Toko Pisang Goreng',
    ]);
});

test('gagal menambah bisnis dengan nama terlalu panjang', function () {
    $longName = str_repeat('A', 256); // 256 karakter

    $response = $this->withoutMiddleware()->post(route('admin.kelola-bisnis.add'), [
        'name' => $longName,
        'lokasi' => 'Jalan Mawar No. 10',
    ]);

    // Pastikan ada error validasi
    $response->assertSessionHasErrors('name');

    // Pastikan data tidak masuk database
    $this->assertDatabaseMissing('business', [
        'lokasi' => 'Jalan Mawar No. 10',
    ]);
});


