<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

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
            'password' => bcrypt('adminLI4'),
        ]);

        $liley->assignRole('super_admin');
    }
}
