<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Super Admin
        User::create([
            'name' => 'Admin Dinas Kesehatan',
            'username' => 'admin',
            'password' => Hash::make('admin123'),
            'level' => 'admin',
            'bidang' => 'admin',
        ]);

        // Admin: Kepala Dinas
        User::create([
            'name' => 'Kepala Dinas',
            'username' => 'kadis',
            'password' => Hash::make('admin123'),
            'level' => 'admin',
            'bidang' => 'admin',
        ]);

        // Admin: Sekretaris Dinas
        User::create([
            'name' => 'Sekretaris Dinas',
            'username' => 'sekdis',
            'password' => Hash::make('admin123'),
            'level' => 'admin',
            'bidang' => 'admin',
        ]);

        // Daftar bidang & user biasa
        $users = [
            ['name' => 'Kesehatan Masyarakat', 'username' => 'kesmasdinkes', 'bidang' => 'kesmas'],
            ['name' => 'Pencegahan dan Pengendalian Penyakit', 'username' => 'p2pdinkes', 'bidang' => 'p2p'],
            ['name' => 'Program dan Informasi', 'username' => 'progsidinkes', 'bidang' => 'progsi'],
            ['name' => 'Yan-SDK', 'username' => 'yansdkdinkes', 'bidang' => 'yansdk'],
            ['name' => 'Sekretariat', 'username' => 'sekretariatdinkes', 'bidang' => 'sekretariat'],
        ];

        foreach ($users as $user) {
            // Admin: Kepala Bidang
            User::create([
                'name' => 'Kepala Bidang ' . $user['name'],
                'username' => 'kabid' . $user['bidang'],
                'password' => Hash::make('admin123'),
                'level' => 'admin',
                'bidang' => $user['bidang'],
            ]);

            // User Biasa
            User::create([
                'name' => $user['name'],
                'username' => $user['username'],
                'password' => Hash::make('user123'),
                'level' => 'user',
                'bidang' => $user['bidang'],
            ]);
        }
    }
}
