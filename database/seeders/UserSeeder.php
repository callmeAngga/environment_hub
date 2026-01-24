<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run()
    {
        User::create([
            'name' => 'Administrator',
            'username' => 'adminhub',
            'password' => Hash::make('indofood2026'),
            'role' => 'ADMIN'
        ]);

        User::create([
            'name' => 'Dito',
            'username' => 'userdito',
            'password' => Hash::make('dito2026'),
            'role' => 'USER'
        ]);
    }
}
