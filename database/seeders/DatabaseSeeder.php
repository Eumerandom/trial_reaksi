<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        $user = User::factory()->create([
            'name' => 'Adminlia',
            'email' => 'adminli@gmail.com',
            'passwird' => bcrypt('adminLI4')
        ]);

        $user->assignRole('super-admin');

        // Seed with proper order due to foreign key constraints
        $this->call([
            CompanySeeder::class,   // First: Create companies (parent and child)
            CategorySeeder::class,   // Second: Create categories (parent and child)
            ProductSeeder::class,    // Last: Create products (needs companies and categories)
        ]);
    }
}
