<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;

class SuperUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $liley = User::create([
            'name' => 'Adminlia',
            'email' => 'adminli@gmail.com',
            'password' => bcrypt('adminLI4')
        ]);

        $liley->assignRole('super_admin');
    }   
}
