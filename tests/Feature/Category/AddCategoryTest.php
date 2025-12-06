<?php

namespace Tests\Feature\Category;

use Tests\TestCase;
use App\Models\Business;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithoutMiddleware;

class AddCategoryTest extends TestCase
{
    use RefreshDatabase, WithoutMiddleware;

    /** TC-01 : Success */
    public function TC01_Success()
    {
        $business = Business::factory()->create();

        $response = $this->post(route('admin.category.add'), [
            'business_id' => $business->id,
            'nama' => 'Makanan'
        ]);

        $response->assertStatus(302);
        $response->assertSessionHas('success', 'Kategori berhasil ditambahkan.');

        $this->assertDatabaseHas('categories', [
            'business_id' => $business->id,
            'nama' => 'Makanan'
        ]);
    }

    /** TC-02 : business_id empty */
    public function TC02_business_id_empty()
    {
        $response = $this->post(route('admin.category.add'), [
            'business_id' => '',
            'nama' => 'Makanan'
        ]);

        $response->assertStatus(302);
        $response->assertSessionHasErrors(['business_id']);
    }

    /** TC-03 : business_id not exists */
    public function TC03_business_id_not_exists()
    {
        $response = $this->post(route('admin.category.add'), [
            'business_id' => 999,
            'nama' => 'Makanan'
        ]);

        $response->assertStatus(302);
        $response->assertSessionHasErrors(['business_id']);
    }

    /** TC-04 : nama empty */
    public function TC04_nama_empty()
    {
        $business = Business::factory()->create();

        $response = $this->post(route('admin.category.add'), [
            'business_id' => $business->id,
            'nama' => ''
        ]);

        $response->assertStatus(302);
        $response->assertSessionHasErrors(['nama']);
    }

    /** TC-05 : nama > 255 karakter */
    public function TC05_nama_lebih_255_karakter()
    {
        $business = Business::factory()->create();
        $longText = str_repeat('A', 256);

        $response = $this->post(route('admin.category.add'), [
            'business_id' => $business->id,
            'nama' => $longText
        ]);

        $response->assertStatus(302);
        $response->assertSessionHasErrors(['nama']);
    }

    /** TC-06 : nama bukan string */
    public function TC06_nama_bukan_string()
    {
        $business = Business::factory()->create();

        $response = $this->post(route('admin.category.add'), [
            'business_id' => $business->id,
            'nama' => 12345
        ]);

        $response->assertStatus(302);
        $response->assertSessionHasErrors(['nama']);
    }
}
