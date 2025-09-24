<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\User;

class RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $adminRole = Role::firstOrCreate(['name' => 'admin']);
        $userRole = Role::firstOrCreate(['name' => 'user']);

        $editPermission = Permission::firstOrCreate(['name' => 'edit articles']);
        $viewPermission = Permission::firstOrCreate(['name' => 'view articles']);


        $adminRole->givePermissionTo($editPermission, $viewPermission);
        $userRole->givePermissionTo($viewPermission);


        $user = User::find(1);
        $user->assignRole('admin');
    }
}
