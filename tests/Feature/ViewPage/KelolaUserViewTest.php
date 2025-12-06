<?php

namespace Tests\Feature\ViewPage;

use Tests\TestCase;
use App\Models\User;
use App\Models\Business;
use Illuminate\Foundation\Testing\RefreshDatabase;

class KelolaUserViewTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function owner_can_access_verify_users_page()
    {
        // Buat business
        $business = Business::factory()->create();

        // Arrange: buat owner
        $owner = User::factory()->create([
            'role' => 'owner',
            'is_verified' => true,
        ]);

        // Buat beberapa users non-owner
        User::factory()->count(3)->create(['role' => 'pegawai', 'id_business' => $business->id]);

        // Act: owner akses halaman
        $response = $this->actingAs($owner)->get(route('admin.verify-users'));

        // Assert
        $response->assertStatus(200);
        $response->assertViewIs('admin.manage-user.verify-users');
        $response->assertViewHas('users');
        $response->assertViewHas('businesses');
    }

    /** @test */
    public function redirect_to_login_if_not_logged_in()
    {
        $response = $this->get(route('admin.verify-users'));

        $response->assertRedirect(route('login'));
    }
}
