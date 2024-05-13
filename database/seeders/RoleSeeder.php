<?php

namespace Database\Seeders;

use App\Models\Permissions\Permission;
use App\Models\Permissions\Role;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $superAdminRole = Role::firstOrCreate(['id' => 1, 'name' => 'Super Admin']);
        $adminRole = Role::firstOrCreate(['id' => 2, 'name' => 'Admin']);
        $employeeRole = Role::firstOrCreate(['id' => 3, 'name' => 'Funcionário']);

        $allPermissions = Permission::all()->pluck('id');

        $superAdminRole->permissions()->sync($allPermissions);
        $adminRole->permissions()->sync([1,2,3,4,5,6,7,8,9,10,11,13,15]);
    }
}
