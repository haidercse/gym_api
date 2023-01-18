<?php

namespace Database\Seeders;
use Faker\Factory;
use App\Models\Member;
use Illuminate\Database\Seeder;

class MemberSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Factory::create();
        foreach (range(1,25) as $key => $value) {
            Member::create([
                'member_id'=> date('Y').str_pad($value,6,0,STR_PAD_LEFT),
                'name' => $faker->name,
                'gender' => rand(0,1),
                'mobile_number' => '01'.rand(3,9).rand(00000000,99999999),
                'blood' => $faker->bloodGroup(),
                'address'=> $faker->address,
                'image' => $faker->imageUrl,
                'create_by' => rand(1,25)
            ]);
        }
    }
}
