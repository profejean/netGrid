<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'name' => 'admin',
            'email' => 'admin@netgrid.test',
            'password' => bcrypt('password'),
            'address' => 'world',
            'birthdate' => '2022-10-20',
            'city' => 'only'

        ]);
    }
}
