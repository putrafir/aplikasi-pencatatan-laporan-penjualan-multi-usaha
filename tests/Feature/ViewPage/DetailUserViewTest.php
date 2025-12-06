<?php

namespace Tests\Feature\ViewPage;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

class DetailUserViewTestTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function test_owner_can_access_user_detail_page()
    {
        // Arrange
        $owner = User::factory()->create([
            'role' => 'owner',
            'is_verified' => true,
        ]);

        // 1. Buat user dummy
        $user = User::factory()->create();

        // 2. Akses route detail
        $response = $this->actingAs($owner)->get(route('admin.users.detail', $user->id));

        // 3. Pastikan status OK
        $response->assertStatus(200);

        // 4. Pastikan view yang digunakan benar
        $response->assertViewIs('admin.manage-user.detail');

        // 5. Pastikan data user dikirim ke view
        $response->assertViewHas('user', function ($viewUser) use ($user) {
            return $viewUser->id === $user->id;
        });
    }

    /** @test */
    public function it_will_return_302_if_user_not_found()
    {
        // Akses route dengan id yang tidak ada
        $response = $this->get(route('admin.users.detail', 99999));

        // Karena menggunakan findOrFail, maka otomatis 302
        $response->assertStatus(302);
    }

    /** @test */
    public function guest_cannot_access_detail_user_page()
    {
        $user = User::factory()->create();

        $response = $this->get(route('admin.users.detail', $user->id));

        $response->assertRedirect('/login');
    }
}
