<?php

namespace Tests\Feature\KelolaUser;

use Tests\TestCase;
use App\Models\User;
use App\Models\Business;
use Illuminate\Foundation\Testing\RefreshDatabase;

class VerifyUserTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_can_verify_a_user()
    {
        // User default is_verified = false
        $user = User::factory()->create([
            'role' => 'pegawai',
            'is_verified' => false,
        ]);

        // Hit ke route verify
        $response = $this->withoutMiddleware()->post(route('admin.verify-user', $user));

        // Assert data berubah
        $user->refresh();
        $this->assertTrue($user->is_verified);

        // Assert redirect & flash message
        $response->assertRedirect();
        $response->assertSessionHas('success', 'Akun berhasil di verifikasi.');
    }

    /** @test */
    public function it_can_unverify_a_user()
    {
        // User dalam kondisi sudah verified
        $user = User::factory()->create([
            'role' => 'pegawai',
            'is_verified' => true,
        ]);

        // Hit ke route unverify
        $response = $this->withoutMiddleware()->post(route('admin.inverify-user', $user));

        // Assert data berubah
        $user->refresh();
        $this->assertFalse($user->is_verified);

        // Assert redirect & flash message
        $response->assertRedirect();
        $response->assertSessionHas('success', 'Akun berhasil di inverifikasi.');
    }
}
