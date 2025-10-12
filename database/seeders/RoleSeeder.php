<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Artisan;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $superAdmin = Role::create(['name' => 'super_admin', 'guard_name' => 'web']);
        $superAdmin->givePermissionTo(\Spatie\Permission\Models\Permission::all());
        Artisan::call('shield:generate', ['--all' => true]);
    }
}
