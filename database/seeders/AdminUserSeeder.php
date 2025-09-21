<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Spatie\Permission\Models\Role;

class AdminUserSeeder extends Seeder
{
    public function run()
    {
        if (!Role::where('name', 'admin')->exists()) {
            Role::create(['name' => 'admin']);
        }

        $user = User::firstOrCreate(
            ['email' => 'es@example.com'],
            [
                'name' => 'es',
                'password' => bcrypt('Example1@')
            ]
        );

        $user->assignRole('admin');
    }
}
