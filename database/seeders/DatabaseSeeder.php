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

        // Run PostSeeder after user creation as posts need an author
        $this->call([
            PostSeeder::class,      // First: Create posts (needs users only)
            CompanySeeder::class,   // Second: Create companies (parent and child)
            CategorySeeder::class,  // Third: Create categories (parent and child)
            ProductSeeder::class,   // Last: Create products (needs companies and categories)
        ]);
    }
}
