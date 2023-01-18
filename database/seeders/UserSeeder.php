<?php

namespace Database\Seeders;

use App\Models\User;
use Faker\Factory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
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

        foreach (range(1, 25) as $value) {
            User::create([
                'name' => $faker->name,
                'email' => $faker->unique()->email,
                'password' => Hash::make('12345678'),
            ]);
        }

        DB::table('oauth_clients')->insert([
            "name" => "Laravel Password Grant
            Client",
            "secret" => "RZQISinMO4bT27EFwHcpMloi2QtEDvbA7ZQ9TkAk",
            "provider" => "users",
            "redirect" => "http://localhost:8000",
            "personal_access_client" => "1",
            "password_client" => "0",
            "revoked" => "0",
            'created_at' => now(),
            'updated_at' => now()
        ]);
        DB::table('oauth_clients')->insert([
            "name" => "Laravel Personal Access
            Client",
            "secret" => "d78wwJGfHASCwUJ5C6vgCeZxJvofALI82R8H8YAO",
            "provider" => "users",
            "redirect" => "http://localhost:8000",
            "personal_access_client" => "0",
            "password_client" => "1",
            "revoked" => "0",
            'created_at' => now(),
            'updated_at' => now()
        ]);

        DB::table('oauth_personal_access_clients')->insert([
             'id' => 1,
             'client_id' => 1,
             'created_at' => now(),
             'updated_at' => now()
        ]);
    }
}
