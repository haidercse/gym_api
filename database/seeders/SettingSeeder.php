<?php

namespace Database\Seeders;

use Faker\Factory;
use App\Models\Setting;
use Illuminate\Database\Seeder;

class SettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Factory::create();
        Setting::create([
            'name' => $faker->name,
            'logo' => $faker->imageUrl(),
            'favicon' => $faker->imageUrl(),
            'email' => $faker->email,
            'mobile' => '01814256957',
            'create_by' => rand(1,15),
        ]);
    }
}