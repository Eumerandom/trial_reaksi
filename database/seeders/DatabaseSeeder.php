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
        $this->call([
            CompanySeeder::class,   // Second: Create companies (parent and child)
            CategorySeeder::class,  
            ProductSeeder::class,   
            RoleSeeder::class,      
            SuperUserSeeder::class, 
            PostSeeder::class,      
        ]);
    }
}
