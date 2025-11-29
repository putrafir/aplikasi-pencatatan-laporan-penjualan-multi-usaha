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
