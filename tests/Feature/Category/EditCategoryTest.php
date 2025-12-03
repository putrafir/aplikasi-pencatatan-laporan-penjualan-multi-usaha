<?php

namespace Tests\Feature\Category;

use Tests\TestCase;
use App\Models\Business;
use App\Models\Category;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithoutMiddleware;

class EditCategoryTest extends TestCase
{
    use RefreshDatabase, WithoutMiddleware;

    /** TC-01 : Update sukses */
    public function TC01_Update_sukses()
    {
        $business = Business::factory()->create();
        $category = Category::factory()->create([
            'business_id' => $business->id,
            'nama' => 'Lama'
        ]);

        $response = $this->put(route('admin.kategori.update', $category->id), [
            'business_id' => $business->id,
            'nama' => 'Kategori Baru'
        ]);

        $response->assertStatus(302);
        $response->assertSessionHas('success', 'Kategori berhasil diperbarui.');

        $this->assertDatabaseHas('categories', [
            'id' => $category->id,
            'business_id' => $business->id,
            'nama' => 'Kategori Baru'
        ]);
    }

    /** TC-02 : nama empty */
    public function TC02_nama_empty()
    {
        $business = Business::factory()->create();
        $category = Category::factory()->create([
            'business_id' => $business->id
        ]);

        $response = $this->put(route('admin.kategori.update', $category->id), [
            'business_id' => $business->id,
            'nama' => ''
        ]);

        $response->assertStatus(302);
        $response->assertSessionHasErrors(['nama']);
    }

    /** TC-03 : nama lebih dari 255 karakter */
    public function TC03_nama_lebih_dari_255_karakter()
    {
        $business = Business::factory()->create();
        $category = Category::factory()->create([
            'business_id' => $business->id
        ]);

        $longText = str_repeat('A', 256);

        $response = $this->put(route('admin.kategori.update', $category->id), [
            'business_id' => $business->id,
            'nama' => $longText
        ]);

        $response->assertStatus(302);
        $response->assertSessionHasErrors(['nama']);
    }

    /** TC-04 : nama bukan string */
    public function TC04_nama_bukan_string()
    {
        $business = Business::factory()->create();
        $category = Category::factory()->create([
            'business_id' => $business->id
        ]);

        $response = $this->put(route('admin.kategori.update', $category->id), [
            'business_id' => $business->id,
            'nama' => 12345
        ]);

        $response->assertStatus(302);
        $response->assertSessionHasErrors(['nama']);
    }

    /** TC-05 : business_id empty */
    public function TC05_business_id_empty()
    {
        $business = Business::factory()->create();
        $category = Category::factory()->create([
            'business_id' => $business->id
        ]);

        $response = $this->put(route('admin.kategori.update', $category->id), [
            'business_id' => '',
            'nama' => 'Kategori Update'
        ]);

        $response->assertStatus(302);
        $response->assertSessionHasErrors(['business_id']);
    }

    /** TC-06 : business_id not exists */
    public function TC06_business_id_not_exists()
    {
        $business = Business::factory()->create();
        $category = Category::factory()->create([
            'business_id' => $business->id
        ]);

        $response = $this->put(route('admin.kategori.update', $category->id), [
            'business_id' => 999,
            'nama' => 'Kategori Update'
        ]);

        $response->assertStatus(302);
        $response->assertSessionHasErrors(['business_id']);
    }
}
