<?php

namespace Database\Seeders;

use App\Models\User;
use Faker\Factory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Factory::create();

        User::create([
             'name' => 'gym_admin',
             'email' => 'gym_admin@gmail.com',
             'password' => Hash::make('12345678'),
        ]);

        foreach(range(1,25) as $value){
            User::create([
                'name' => $faker->name,
                'email' => $faker->unique()->email,
                'password' => Hash::make('12345678'),
           ]);
        }
    }
}
