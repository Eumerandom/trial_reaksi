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
        Artisan::call('shield:generate', [
            '--all' => true,
            '--panel' => 'admin',
            '--option' => 'policies_and_permissions',
        ]);

        $superAdmin = Role::firstOrCreate(
            ['name' => 'super_admin', 'guard_name' => 'web']
        );
        $superAdmin->syncPermissions(\Spatie\Permission\Models\Permission::all());
    }
}
