<?php

namespace Tests\Feature\KelolaUser;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UpdateUserTest extends TestCase
{
    use RefreshDatabase;

    private $owner;
    private $user;

    protected function setUp(): void
    {
        parent::setUp();

        // Login sebagai owner
        $this->owner = User::factory()->create([
            'role' => 'owner',
            'email' => 'owner@mail.com',
        ]);

        $this->actingAs($this->owner);

        // User yang akan di-update
        $this->user = User::factory()->create([
            'name'  => 'Old Name',
            'email' => 'budi@company.com',
        ]);
    }

    /** TC-U01: Berhasil update dan redirect */
    public function test_update_user_success()
    {
        $response = $this->withoutMiddleware()
            ->put(route('admin.users.update', $this->user->id), [
                'name'  => 'Budi Setiawan',
                'email' => 'budi@company.com',
            ]);

        $response->assertRedirect(route('admin.users.detail', $this->user->id));
        $response->assertSessionHas('success');

        $this->assertDatabaseHas('users', [
            'id'    => $this->user->id,
            'name'  => 'Budi Setiawan',
        ]);
    }

    /** TC-U02: Name required */
    public function test_name_required()
    {
        $response = $this->withoutMiddleware()
            ->put(route('admin.users.update', $this->user->id), [
                'name'  => '',
                'email' => 'budi@company.com',
            ]);

        $response->assertSessionHasErrors([
            'name' => 'name field required'
        ]);
    }

    /** TC-U03: Name > 255 chars */
    public function test_name_max_length()
    {
        $response = $this->withoutMiddleware()
            ->put(route('admin.users.update', $this->user->id), [
                'name'  => str_repeat('a', 256),
                'email' => 'budi@company.com',
            ]);

        $response->assertSessionHasErrors([
            'name' => 'name may not be greater than 255 characters'
        ]);
    }

    /** TC-U04: Email required */
    public function test_email_required()
    {
        $response = $this->withoutMiddleware()
            ->put(route('admin.users.update', $this->user->id), [
                'name'  => 'Budi',
                'email' => '',
            ]);

        $response->assertSessionHasErrors([
            'email' => 'email field required'
        ]);
    }

    /** TC-U05: Email invalid format */
    public function test_email_invalid_format()
    {
        $response = $this->withoutMiddleware()
            ->put(route('admin.users.update', $this->user->id), [
                'name'  => 'Budi',
                'email' => 'budi.com',
            ]);

        $response->assertSessionHasErrors([
            'email' => 'email must be a valid email address'
        ]);
    }

    /** TC-U06: Email user sendiri (not duplicate) */
    public function test_update_with_same_email_should_pass()
    {
        $response = $this->withoutMiddleware()
            ->put(route('admin.users.update', $this->user->id), [
                'name'  => 'Nama Baru',
                'email' => 'budi@company.com',
            ]);

        $response->assertSessionDoesntHaveErrors();
        $response->assertRedirect(route('admin.users.detail', $this->user->id));
    }

    /** TC-U07: Email duplicate */
    public function test_email_duplicate()
    {
        User::factory()->create([
            'email' => 'admin@mail.com',
        ]);

        $response = $this->withoutMiddleware()
            ->put(route('admin.users.update', $this->user->id), [
                'name'  => 'Budi',
                'email' => 'admin@mail.com',
            ]);

        $response->assertSessionHasErrors([
            'email' => 'The email has already been taken'
        ]);
    }

    /** TC-U08: Update email valid */
    public function test_update_email_success()
    {
        $response = $this->withoutMiddleware()
            ->put(route('admin.users.update', $this->user->id), [
                'name'  => 'New Name',
                'email' => 'new@mail.com',
            ]);

        $response->assertRedirect(route('admin.users.detail', $this->user->id));

        $this->assertDatabaseHas('users', [
            'id'    => $this->user->id,
            'email' => 'new@mail.com',
        ]);
    }

    /** TC-U09: hanya name berubah */
    public function test_update_name_only()
    {
        $response = $this->withoutMiddleware()
            ->put(route('admin.users.update', $this->user->id), [
                'name'  => 'Updated Name',
                'email' => 'budi@company.com',
            ]);

        $response->assertRedirect(route('admin.users.detail', $this->user->id));

        $this->assertDatabaseHas('users', [
            'id'   => $this->user->id,
            'name' => 'Updated Name',
        ]);
    }
}
