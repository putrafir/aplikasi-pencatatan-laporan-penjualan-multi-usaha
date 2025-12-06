<?php

namespace Tests\Feature\KelolaUser;

use Tests\TestCase;
use App\Models\User;
use App\Models\Business;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AddUserTest extends TestCase
{
    use RefreshDatabase;

    private $business;
    private $owner;

    protected function setUp(): void
    {
        parent::setUp();

        // Business valid
        $this->business = Business::factory()->create();

        // Login sebagai owner agar bisa akses route
        $this->owner = User::factory()->create([
            'role' => 'owner',
            'email' => 'owner@mail.com',
            'password' => bcrypt('password123'),
        ]);

        $this->actingAs($this->owner); // auth & owner middleware aktif
    }

    /** TC-01 Berhasil menambah user */
    public function test_owner_berhasil_menambahkan_user()
    {
        $response = $this->withoutMiddleware()->post(route('admin.add-user'),[
            'name' => 'Budi',
            'email' => 'budi@shop.com',
            'password' => 'Budi123!',
            'id_business' => $this->business->id,
        ]);

        $response->assertSessionHas('success','Akun berhasil di tambahkan.');
        $this->assertDatabaseHas('users', ['email'=>'budi@shop.com']);
    }

    /** TC-02 name kosong */
    public function test_name_required()
    {
        $response = $this->withoutMiddleware()->post(route('admin.add-user'),[
            'name' => '',
            'email' => 'budi@shop.com',
            'password' => 'Budi123!',
            'id_business' => $this->business->id,
        ]);

        $response->assertSessionHasErrors(['name'=>'The name field is required.']);
    }

    /** TC-03 name > 255 karakter */
    public function test_name_too_long()
    {
        $response = $this->withoutMiddleware()->post(route('admin.add-user'),[
            'name' => str_repeat('a',256),
            'email' => 'budi@shop.com',
            'password' => 'Budi123!',
            'id_business' => $this->business->id,
        ]);

        $response->assertSessionHasErrors(['name'=>'The name may not be greater than 255 characters.']);
    }

    /** TC-04 email kosong */
    public function test_email_required()
    {
        $response = $this->withoutMiddleware()->post(route('admin.add-user'),[
            'name' => 'tes',
            'email' => '',
            'password' => 'Password123!',
            'id_business' => $this->business->id,
        ]);

        $response->assertSessionHasErrors(['email'=>'The email field is required.']);
    }

    /** TC-05 email format salah */
    public function test_email_format_salah()
    {
        $response = $this->withoutMiddleware()->post(route('admin.add-user'),[
            'name' => 'tes',
            'email' => 'budi.com',
            'password' => 'Password123!',
            'id_business' => $this->business->id,
        ]);

        $response->assertSessionHasErrors(['email'=>'The email must be a valid email address.']);
    }

    /** TC-06 email harus lowercase */
    public function test_email_uppercase_invalid()
    {
        $response = $this->withoutMiddleware()->post(route('admin.add-user'),[
            'name' => 'tes',
            'email' => 'BUDI@MAIL.COM',
            'password' => 'Password123!',
            'id_business' => $this->business->id,
        ]);

        $response->assertSessionHasErrors(['email'=>'The email must be lowercase.']);
    }

    /** TC-07 email duplicate */
    public function test_email_duplicate()
    {
        User::factory()->create(['email'=>'budi@shop.com']);

        $response = $this->withoutMiddleware()->post(route('admin.add-user'),[
            'name' => 'tes',
            'email' => 'budi@shop.com',
            'password' => 'Password123!',
            'id_business' => $this->business->id,
        ]);

        $response->assertSessionHasErrors(['email'=>'The email has already been taken.']);
    }

    /** TC-08 password < 8 char */
    public function test_password_min_char()
    {
        $response = $this->withoutMiddleware()->post(route('admin.add-user'),[
            'name' => 'tes',
            'email' => 'tes@mail.com',
            'password' => '123',
            'id_business' => $this->business->id,
        ]);

        $response->assertSessionHasErrors('password');
    }

    /** TC-09 password tidak memenuhi rule strength */
    public function test_password_weak()
    {
        $response = $this->withoutMiddleware()->post(route('admin.add-user'),[
            'name' => 'tes',
            'email' => 'tes@mail.com',
            'password' => 'password',
            'id_business' => $this->business->id,
        ]);

        $response->assertSessionHasErrors(['password' => 'Password is too weak.']);
    }

    /** TC-10 id_business kosong */
    public function test_id_business_required()
    {
        $response = $this->withoutMiddleware()->post(route('admin.add-user'),[
            'name' => 'tes',
            'email' => 'tes@mail.com',
            'password' => 'Password123!',
            'id_business' => '',
        ]);

        $response->assertSessionHasErrors(['id_business'=>'The id business field is required.']);
    }

    /** TC-11 id_business tidak ada di tabel */
    public function test_id_business_invalid()
    {
        $response = $this->withoutMiddleware()->post(route('admin.add-user'),[
            'name' => 'tes',
            'email' => 'tes@mail.com',
            'password' => 'Password123!',
            'id_business' => 9999, // tidak ada di database
        ]);

        $response->assertSessionHasErrors(['id_business'=>'The selected id business is invalid.']);
    }
}
