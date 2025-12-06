<?php

use App\Models\Business;
use App\Models\Category;
use App\Models\Menu;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

test('user dapat menambah menu tanpa gambar', function () {
    $business = Business::factory()->create();
    $category = Category::factory()->create([
        'business_id' => $business->id
    ]);

    $response = $this->withoutMiddleware()
        ->post(route('admin.menu.add'), [
            'business_id' => $business->id,
            'nama' => 'Pisang Goreng',
            'kategori_id' => $category->id,
            'harga' => 15000,
        ]);

    $response->assertRedirect();

    $response->assertSessionHas('success');
    $this->assertDatabaseHas('menus', [
        'business_id' => $business->id,
        'nama' => 'Pisang Goreng',
        'kategori_id' => $category->id,
        'harga' => 15000,

    ]);
});

test('user dapat menambah menu dengan gambar', function () {
    Storage::fake('public');

    $business = Business::factory()->create();
    $category = Category::factory()->create([
        'business_id' => $business->id
    ]);

    $file = UploadedFile::fake()->image('menu.jpg');

    $response = $this->withoutMiddleware()
        ->post(route('admin.menu.add'), [
            'business_id' => $business->id,
            'nama' => 'Ayam Bakar',
            'kategori_id' => $category->id,
            'harga' => 20000,
            'foto' => $file,
        ]);

    $response->assertRedirect();

    $response->assertSessionHas('success');

    $this->assertDatabaseCount('menus', 1);
    $menu = Menu::first();

    $this->assertFileExists(public_path($menu->foto));
    $this->assertStringStartsWith('img/upload/', $menu->foto);
});

test('validasi form ketika field required tidak diisi', function () {
    $response = $this->withoutMiddleware()
        ->post(route('admin.menu.add'), []); // kosong agar semua required error


    $response->assertSessionHasErrors([
        'business_id',
        'nama',
        'kategori_id',
        'harga',
    ]);
});


test('harga harus berupa angka dan lebih besar dari nol', function () {
    // $this->actingAs(User::factory()->create());

    $business = Business::factory()->create();
    $category = Category::factory()->create([
        'business_id' => $business->id
    ]);

    $response = $this->withoutMiddleware()->post(route('admin.menu.add'), [
        'business_id' => $business->id,
        'nama' => 'Test Menu',
        'kategori_id' => $category->id,
        'harga' => -100
    ]);

    $response->assertSessionHasErrors('harga');
});

