<?php

use Phinx\Seed\AbstractSeed;

class UtmDataSeeder extends AbstractSeed
{
    public function run()
    {
        $faker = Faker\Factory::create();

        $data = [];
        for ($i = 0; $i < 100; $i++) {
            $data[] = [
                'source'   => $faker->randomElement(['instagram','snapchat', 'facebook', 'twitter', 'linkedin']),
                'medium'   => $faker->randomElement(['cpc', 'email', 'social', 'referral']),
                'campaign' => $faker->word . '-' . $faker->numberBetween(1, 100),
                'content'  => $faker->optional()->sentence(3),
                'term'     => $faker->optional()->word,
                'created'  => $faker->dateTimeThisYear()->format('Y-m-d H:i:s'),
                'modified' => $faker->dateTimeThisYear()->format('Y-m-d H:i:s'),
            ];
        }
        $this->table('utm_data')->insert($data)->save();
    }
}