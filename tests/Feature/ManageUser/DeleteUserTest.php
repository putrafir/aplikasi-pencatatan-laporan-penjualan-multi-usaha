<?php

namespace Tests\Feature\ManageUser;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;

class DeleteUserTest extends TestCase
{
    use RefreshDatabase, WithoutMiddleware;

    /** @test */
    public function dapat_menghapus_pegawai_tanpa_middleware()
    {
        // Buat pegawai
        $user = User::factory()->create([
            'role' => 'pegawai',
            'is_verified' => true,
        ]);

        // Eksekusi DELETE tanpa login / tanpa middleware auth
        $response = $this->delete(route('admin.users.delete', $user->id));

        // Pastikan redirect dan pesan sukses muncul
        $response->assertRedirect(route('admin.verify-users'));
        $response->assertSessionHas('success', 'Pegawai berhasil dihapus');

        // Pastikan data benar-benar terhapus dari database
        $this->assertDatabaseMissing('users', [
            'id' => $user->id
        ]);
    }
}
