<?php

namespace Tests\Feature\ViewPage;

use Tests\TestCase;
use App\Models\User;
use App\Models\Business;
use Illuminate\Foundation\Testing\RefreshDatabase;

class KelolaBisnisViewTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function owner_can_access_kelola_bisnis_page()
    {
        // Arrange
        $owner = User::factory()->create([
            'role' => 'owner',
            'is_verified' => true,
        ]);

        // Create dummy business
        Business::factory()->count(3)->create();

        // Act
        $response = $this->actingAs($owner)
            ->get(route('admin.kelola-bisnis'));

        // Assert
        $response->assertStatus(200);
        $response->assertViewIs('admin.kelola-bisnis.index');
        $response->assertViewHas('business');
    }

    /** @test */
    public function kelola_bisnis_page_can_filter_using_search_query()
    {
        // Arrange
        $owner = User::factory()->create([
            'role' => 'owner',
            'is_verified' => true,
        ]);

        Business::factory()->create(['name' => 'Warung Maju Jaya']);
        Business::factory()->create(['name' => 'Toko Bambu']);
        Business::factory()->create(['name' => 'Maju Terus']);

        // Act
        $response = $this->actingAs($owner)->get(route('admin.kelola-bisnis', [
            'search' => 'Maju'
        ]));

        // Assert
        $response->assertStatus(200);
        $response->assertViewIs('admin.kelola-bisnis.index');

        // Mengecek apakah hanya business yang ada kata "Maju"
        $response->assertViewHas('business', function ($businesses) {
            return $businesses->count() === 2
                && $businesses->pluck('name')->contains('Warung Maju Jaya')
                && $businesses->pluck('name')->contains('Maju Terus');
        });
    }

    /** @test */
    public function guest_cannot_access_kelola_bisnis_page()
    {
        $response = $this->get(route('admin.kelola-bisnis'));

        $response->assertRedirect('/login');
    }
}