<?php

namespace Tests\Feature\ViewPage;

use Tests\TestCase;
use App\Models\User;
use App\Models\Stock;
use App\Models\Business;
use App\Models\RiwayatStok;
use Illuminate\Foundation\Testing\RefreshDatabase;

class TambahStockViewTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_can_access_manage_stock_page()
    {
        // Arrange
        $owner = User::factory()->create([
            'role' => 'owner',
            'is_verified' => true,
        ]);

        $business = Business::factory()->create();
        $stock = Stock::factory()->create(['business_id' => $business->id]);

        $response = $this->actingAs($owner)
            ->get(route('admin.manage-stock', $business->id));

        $response->assertStatus(200);
        $response->assertViewIs('admin.manage-stock.index');
        $response->assertViewHasAll(['stocks', 'business_name', 'riwayatStok', 'businesses', 'datanama', 'business_id']);
    }

    /** @test */
    public function it_filters_stocks_by_business_id()
    {
        // Arrange
        $owner = User::factory()->create([
            'role' => 'owner',
            'is_verified' => true,
        ]);

        $businessA = Business::factory()->create();
        $businessB = Business::factory()->create();

        $stockA = Stock::factory()->create(['business_id' => $businessA->id]);
        $stockB = Stock::factory()->create(['business_id' => $businessB->id]);

        $response = $this->actingAs($owner)
            ->get(route('admin.manage-stock', $businessA->id));

        $stocks = $response->viewData('stocks');

        $this->assertTrue($stocks->contains('id', $stockA->id));
        $this->assertFalse($stocks->contains('id', $stockB->id));
    }

    /** @test */
    public function it_shows_correct_business_name()
    {
        // Arrange
        $owner = User::factory()->create([
            'role' => 'owner',
            'is_verified' => true,
        ]);

        $business = Business::factory()->create(['name' => 'Warung Reza']);

        $response = $this->actingAs($owner)
            ->get(route('admin.manage-stock', $business->id));

        $business_name = $response->viewData('business_name');

        $this->assertEquals('Warung Reza', $business_name->name);
    }

    /** @test */
    public function it_shows_only_the_latest_5_stock_history_logs()
    {
        // Arrange
        $owner = User::factory()->create([
            'role' => 'owner',
            'is_verified' => true,
        ]);
        
        $business = Business::factory()->create();
        $stock = Stock::factory()->create(['business_id' => $business->id]);

        // Buat 10 log
        RiwayatStok::factory()->count(10)->create(['stock_id' => $stock->id, 'user_id' => $owner->id]);

        $response = $this->actingAs($owner)
            ->get(route('admin.manage-stock', $business->id));

        $riwayatStok = $response->viewData('riwayatStok');

        $this->assertCount(5, $riwayatStok);

        // Pastikan urut dari terbaru
        $this->assertTrue($riwayatStok->first()->id > $riwayatStok->last()->id);
    }

    /** @test */
    public function it_requires_authentication_to_access_tambah_stock_page()
    {
        $business = Business::factory()->create();
        
        $response = $this->get(route('admin.manage-stock', $business->id));

        $response->assertRedirect('/login'); // atau route login lain jika beda
    }
}
