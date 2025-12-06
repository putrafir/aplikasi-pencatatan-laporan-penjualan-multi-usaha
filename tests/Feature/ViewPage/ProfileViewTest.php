<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ProfileViewTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_requires_authentication_to_access_profile_page()
    {
        $response = $this->get('/profile');

        $response->assertRedirect('/login'); // atau route login lain jika beda
    }

    /** @test */
    public function it_displays_profile_page_with_logged_in_user()
    {
        // Arrange: buat user & login
        $user = User::factory()->create();

        // Act: akses halaman profil
        $response = $this->actingAs($user)->get('/profile');

        // Assert: view dan data user tersedia
        $response->assertStatus(200)
                 ->assertViewIs('profile.index')
                 ->assertViewHas('user', function ($viewUser) use ($user) {
                     return $viewUser->id === $user->id;
                 });
    }
}
