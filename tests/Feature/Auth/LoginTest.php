<?php

namespace Tests\Feature\Auth;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Illuminate\Support\Facades\Hash;

class LoginTest extends TestCase
{
    use RefreshDatabase;

    private function createUser()
    {
        return User::factory()->create([
            'email' => 'user@gmail.com',
            'password' => Hash::make('Abcde123!'),
            'is_verified' => true,
            'role' => 'owner',
        ]);
    }

    /** TC01: Login berhasil */
    public function test_TC01_login_berhasil()
    {
        $this->createUser();

        $response = $this->post('/login', [
            'email' => 'user@gmail.com',
            'password' => 'Abcde123!',
        ]);

        $response->assertRedirect(route('owner.dashboard') . '?verified=1');
    }

    /** TC02: Email kosong */
    public function test_TC02_email_kosong()
    {
        $response = $this->post('/login', [
            'email' => '',
            'password' => 'Abcde123!',
        ]);

        $response->assertSessionHasErrors('email');
    }

    /** TC03: Format email tidak valid */
    public function test_TC03_email_tidak_valid()
    {
        $response = $this->post('/login', [
            'email' => 'usergmail.com',
            'password' => 'Abcde123!',
        ]);

        $response->assertSessionHasErrors('email');
    }

    /** TC04: Password kosong */
    public function test_TC04_password_kosong()
    {
        $response = $this->post('/login', [
            'email' => 'user@gmail.com',
            'password' => '',
        ]);

        $response->assertSessionHasErrors('password');
    }

    /** TC05: Password terlalu pendek */
    public function test_TC05_password_terlalu_pendek()
    {
        $response = $this->post('/login', [
            'email' => 'user@gmail.com',
            'password' => '12345',
        ]);
 
        $response->assertSessionHasErrors('password');
    }

    /** TC06: Email tidak ditemukan */
    public function test_TC06_email_tidak_ditemukan()
    {
        $response = $this->post('/login', [
            'email' => 'unknow@mail.com',
            'password' => 'Abcde123!',
        ]);

        $response->assertSessionHasErrors('email');
    }

    /** TC07: Password salah */
    public function test_TC07_password_salah()
    {
        $this->createUser();

        $response = $this->post('/login', [
            'email' => 'user@gmail.com',
            'password' => 'wrongpass!',
        ]);

        $response->assertSessionHasErrors('email');
    }

    /** TC08: Domain email tidak valid */
    public function test_TC08_email_domain_tidak_valid()
    {
        $response = $this->post('/login', [
            'email' => 'user@',
            'password' => 'Abcde123!',
        ]);

        $response->assertSessionHasErrors('email');
    }

    /** TC09: Email mengandung spasi */
    public function test_TC09_email_mengandung_spasi()
    {
        $response = $this->post('/login', [
            'email' => 'user test@gmail.com',
            'password' => 'Abcde123!',
        ]);

        $response->assertSessionHasErrors('email');
    }

    /** TC10: Password tidak mengandung kombinasi */
    public function test_TC10_password_tidak_kombinasi()
    {
        $response = $this->post('/login', [
            'email' => 'user@gmail.com',
            'password' => 'Abcdefgh',
        ]);

        $response->assertSessionHasErrors('password');
    }
}
