<?php

use App\Models\Business;
use App\Models\Category;
use App\Models\Menu;

test('dapat edit menu', function () {
    $business = Business::factory()->create();
    $category = Category::factory()->create([
        'business_id' => $business->id
    ]);
    $menu = Menu::factory()->create([
        'business_id' => $business->id,
        'kategori_id' => $category->id,
        'nama' => 'Smoothies Mangga',
        'harga' => 12000,
    ]);

    $response = $this->withoutMiddleware()->put(route('admin.menus.update', $menu->id), [
        'business_id' => $business->id,
        'nama' => 'Smoothies Mangga Spesial',
        'kategori_id' => $category->id,
        'harga' => 15000,
    ]);

    $response->assertRedirect();

    $response->assertSessionHas('success');
    $this->assertDatabaseHas('menus', [
        'id' => $menu->id,
        'business_id' => $business->id,
        'nama' => 'Smoothies Mangga Spesial',
        'kategori_id' => $category->id,
        'harga' => 15000,
    ]);


});

test('gagal edit menu tanpa nama', function () {
    $business = Business::factory()->create();
    $category = Category::factory()->create([
        'business_id' => $business->id
    ]);
    $menu = Menu::factory()->create([
        'business_id' => $business->id,
        'kategori_id' => $category->id,
        'nama' => 'Smoothies Mangga',
        'harga' => 12000,
    ]);

    $response = $this->withoutMiddleware()->put(route('admin.menus.update', $menu->id), [
        'business_id' => $business->id,
        'nama' => '',
        'kategori_id' => $category->id,
        'harga' => 15000,
    ]);

    // Pastikan ada error validasi
    $response->assertSessionHasErrors('nama');

    // Pastikan data tidak berubah di database
    $this->assertDatabaseHas('menus', [
        'id' => $menu->id,
        'business_id' => $business->id,
        'nama' => 'Smoothies Mangga',
        'kategori_id' => $category->id,
        'harga' => 12000,
    ]);
});

test('gagal edit menu tanpa harga', function () {
    $business = Business::factory()->create();
    $category = Category::factory()->create([
        'business_id' => $business->id
    ]);
    $menu = Menu::factory()->create([
        'business_id' => $business->id,
        'kategori_id' => $category->id,
        'nama' => 'Smoothies Mangga',
        'harga' => 12000,
    ]);

    $response = $this->withoutMiddleware()->put(route('admin.menus.update', $menu->id), [
        'business_id' => $business->id,
        'nama' => 'Smoothies Mangga Spesial',
        'kategori_id' => $category->id,
        'harga' => '',
    ]);

    // Pastikan ada error validasi
    $response->assertSessionHasErrors('harga');

    // Pastikan data tidak berubah di database
    $this->assertDatabaseHas('menus', [
        'id' => $menu->id,
        'business_id' => $business->id,
        'nama' => 'Smoothies Mangga',
        'kategori_id' => $category->id,
        'harga' => 12000,
    ]);
});

test('gagal edit menu dengan harga negatif', function () {
    $business = Business::factory()->create();
    $category = Category::factory()->create([
        'business_id' => $business->id
    ]);
    $menu = Menu::factory()->create([
        'business_id' => $business->id,
        'kategori_id' => $category->id,
        'nama' => 'Smoothies Mangga',
        'harga' => 12000,
    ]);

    $response = $this->withoutMiddleware()->put(route('admin.menus.update', $menu->id), [
        'business_id' => $business->id,
        'nama' => 'Smoothies Mangga Spesial',
        'kategori_id' => $category->id,
        'harga' => -5000,
    ]);

    // Pastikan ada error validasi
    $response->assertSessionHasErrors('harga');

    // Pastikan data tidak berubah di database
    $this->assertDatabaseHas('menus', [
        'id' => $menu->id,
        'business_id' => $business->id,
        'nama' => 'Smoothies Mangga',
        'kategori_id' => $category->id,
        'harga' => 12000,
    ]);
});
