<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();
        Role::create([
            'name' => 'super_admin',
            'guard_name' => 'web'
        ]);

        $user = User::factory()->create([
            'name' => 'Adminlia',
            'email' => 'adminli@gmail.com',
            'password' => bcrypt('adminLI4')
        ]);

        $user->assignRole('super_admin');

        // Seed with proper order due to foreign key constraints
        $this->call([
            CompanySeeder::class,   // First: Create companies (parent and child)
            CategorySeeder::class,   // Second: Create categories (parent and child)
            ProductSeeder::class,    // Last: Create products (needs companies and categories)
        ]);
    }
}
