<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PegawaiSmoothiesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::factory()->create([
            'name' => 'Tono Ton',
            'email' => 'tono@gmail.com',
            'password' => 'tono1234',
            'role' => 'pegawai',
            'id_business' => 2,
            'is_verified' => true,
        ]);
    }
}
