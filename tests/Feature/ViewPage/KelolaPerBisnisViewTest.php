<?php

namespace Tests\Feature\Admin;

use Tests\TestCase;
use App\Models\User;
use App\Models\Menu;
use App\Models\Stock;
use App\Models\Business;
use Illuminate\Foundation\Testing\RefreshDatabase;

class KelolaPerBisnisViewTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_can_access_kelola_bisnis_page()
    {
        // Arrange
        $owner = User::factory()->create([
            'role' => 'owner',
            'is_verified' => true,
        ]);

        // Arrange: Buat business dengan relasi
        $business = Business::factory()->create();

        // Buat 10 menu dan 10 stock
        Menu::factory()->count(10)->create(['business_id' => $business->id]);
        Stock::factory()->count(10)->create(['business_id' => $business->id]);

        // Act: Hit route kelola bisnis
        $response = $this->actingAs($owner)
            ->get(route('admin.kelola-bisnis.kelola', $business->id));

        // Assert: response status & view
        $response->assertStatus(200);
        $response->assertViewIs('admin.kelola-bisnis.kelola');

        // Pastikan variabel view ada
        $response->assertViewHasAll([
            'business',
            'stocks',
            'totalStocks',
            'menus',
            'totalMenus',
            'perPage',
            'currentPage'
        ]);
    }

    /** @test */
    public function it_paginates_menus_and_stocks_correctly()
    {
        // Arrange
        $owner = User::factory()->create([
            'role' => 'owner',
            'is_verified' => true,
        ]);

        $business = Business::factory()->create();

        // Buat 12 menu dan 12 stock
        Menu::factory()->count(12)->create(['business_id' => $business->id]);
        Stock::factory()->count(12)->create(['business_id' => $business->id]);

        $perPage = 5;

        // =========================
        // PAGE 1
        // =========================
        $response = $this->actingAs($owner)->get(route('admin.kelola-bisnis.kelola', ['id' => $business->id, 'page' => 1]));

        $response->assertStatus(200);

        $menusPage1 = $response->viewData('menus');
        $stocksPage1 = $response->viewData('stocks');

        $this->assertCount($perPage, $menusPage1);
        $this->assertCount($perPage, $stocksPage1);

        // =========================
        // PAGE 2
        // =========================
        $response = $this->actingAs($owner)->get(route('admin.kelola-bisnis.kelola', ['id' => $business->id, 'page' => 2]));

        $response->assertStatus(200);

        $menusPage2 = $response->viewData('menus');
        $stocksPage2 = $response->viewData('stocks');

        $this->assertCount($perPage, $menusPage2);
        $this->assertCount($perPage, $stocksPage2);
    }

    /** @test */
    public function redirect_to_login_if_not_logged_in()
    {
        // Arrange: Buat business dengan relasi
        $business = Business::factory()->create();

        $response = $this->get(route('admin.kelola-bisnis.kelola', $business->id));

        $response->assertRedirect(route('login'));
    }
}
