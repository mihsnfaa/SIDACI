<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Admin
        User::create([
            'name' => 'Admin Dinkes',
            'email' => 'admin@dinkes.com',
            'password' => Hash::make('admin123'),
            'level' => 'admin',
            'bidang' => 'admin',
        ]);

        // User Bidang
        $bidangs = ['kesmas', 'p2p', 'progsi', 'yansdk', 'sekretariat'];
        foreach ($bidangs as $bidang) {
            User::create([
                'name' => 'User ' . ucfirst($bidang),
                'email' => $bidang . '@dinkes.com',
                'password' => Hash::make('user123'),
                'level' => 'user',
                'bidang' => $bidang,
            ]);
        }
    }
}
