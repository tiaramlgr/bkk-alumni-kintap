<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;

class RoleSeeder extends Seeder
{
    public function run()
    {
        // Admin
        User::create([
            'name' => 'Admin BKK',
            'email' => 'admin@bkkkintap.test',
            'password' => bcrypt('password'),
            'role' => 'admin',
            'is_active' => true,
            'email_verified_at' => now(),
        ]);

        echo "✅ Admin default telah dibuat (email: admin@bkkkintap.test | pass: password)\n";
    }
}