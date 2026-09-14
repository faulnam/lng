<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. Akun Role Asli (Password: qwertyu123)
        User::updateOrCreate(
            ['email' => 'admin@nusantara-lng.com'],
            [
                'name' => 'Nusantara LNG Super Admin',
                'password' => Hash::make('qwertyu123'),
                'role' => 'super_admin',
            ]
        );

        User::updateOrCreate(
            ['email' => 'admin@the-metrix.com'],
            [
                'name' => 'Super Administrator',
                'password' => Hash::make('qwertyu123'),
                'role' => 'super_admin',
            ]
        );

        User::updateOrCreate(
            ['email' => 'editor@nusantara-lng.com'],
            [
                'name' => 'LNG Market Editor',
                'password' => Hash::make('qwertyu123'),
                'role' => 'editor',
            ]
        );

        User::updateOrCreate(
            ['email' => 'editor@the-metrix.com'],
            [
                'name' => 'Content Editor',
                'password' => Hash::make('qwertyu123'),
                'role' => 'editor',
            ]
        );

        // 2. Akun Role Demo (Password: password)
        User::updateOrCreate(
            ['email' => 'demo_admin@nusantara-lng.com'],
            [
                'name' => 'Demo Super Admin',
                'password' => Hash::make('password'),
                'role' => 'super_admin',
            ]
        );

        User::updateOrCreate(
            ['email' => 'demo_admin@the-metrix.com'],
            [
                'name' => 'Demo Super Admin (Metrix)',
                'password' => Hash::make('password'),
                'role' => 'super_admin',
            ]
        );

        User::updateOrCreate(
            ['email' => 'demo_editor@nusantara-lng.com'],
            [
                'name' => 'Demo Editor',
                'password' => Hash::make('password'),
                'role' => 'editor',
            ]
        );

        User::updateOrCreate(
            ['email' => 'demo_editor@the-metrix.com'],
            [
                'name' => 'Demo Editor',
                'password' => Hash::make('password'),
                'role' => 'editor',
            ]
        );
    }
}
