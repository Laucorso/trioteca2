<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::firstOrCreate(['email' => 'test@test.com'], [
            'name' => 'Test User',
            'email' => 'test@test.com',
            'password' => bcrypt('root'),
            'active' => 1
        ]);
    }
}