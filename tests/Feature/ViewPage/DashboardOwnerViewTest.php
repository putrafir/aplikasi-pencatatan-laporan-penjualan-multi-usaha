<?php

namespace Tests\Feature\ViewPage;

use Tests\TestCase;
use App\Models\User;
use App\Models\Business;
use Illuminate\Foundation\Testing\RefreshDatabase;

class DashboardOwnerViewTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function test_owner_can_access_dashboard_page()
    {
        // Buat business
        $business = Business::factory()->create();

        // Arrange: buat owner
        $owner = User::factory()->create(['role' => 'owner', 'id_business' => $business->id]);

        // Login sebagai owner
        $response = $this->actingAs($owner)->get(route('owner.dashboard'));

        // Pastikan status OK
        $response->assertStatus(200);

        // Pastikan view benar
        $response->assertViewIs('admin.dashboard');

        // Pastikan variabel view tersedia
        $response->assertViewHasAll([
            'filterMenu',
            'categoriesMenu',
            'menuSeries',
            'totalMenuTerjual',
            'categoriesPendapatan',
            'categoriesStok',
            'seriesPendapatan',
            'stokSeries',
            'filterPendapatan',
            'filterStok',
            'totalPendapatan',
            'totalStokKeluar',
            'bestSeller',
            'filterBestSeller',
            'stokSeringKeluar',
            'filterStokKeluar',
        ]);
    }

    /** @test */
    public function test_dashboard_redirects_if_not_logged_in()
    {
        $response = $this->get('/admin/dashboard');

        // Redirect ke login owner sesuai sistem kamu
        $response->assertRedirect(route('login'));
    }
}
