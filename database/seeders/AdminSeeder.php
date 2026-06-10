<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
    \App\Models\User::create([
        'name' => 'Admin Utama',
        'email' => 'admin@bkk.com',
        'password' => Hash::make('password'),
        'role' => 'admin', 
    ]);
}
}
