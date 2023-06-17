<?php

namespace Database\Seeders;

use Faker\Factory as Faker;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ExperiencesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create();

        for ($i = 1; $i <= 20; $i++) {
            DB::table('histories')->insert([
                'info1'         => $faker->company,
                'title'         => $faker->jobTitle,
                'type'          => 'experience',
                'date_start'    => $faker->dateTimeBetween('-5 years', 'now'),
                'date_end'      => $faker->dateTimeBetween('now', '+5 years'),
                'description'   => (string) $i
            ]);
        }
    }
}
