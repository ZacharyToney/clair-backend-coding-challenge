<?php

namespace Database\Seeders;

use App\Models\Business;
use Illuminate\Database\Seeder;

class BusinessSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($x = 0; $x <= 10; $x++){
            Business::create([
                'name' => fake()->company(),
                'external_id' => fake()->uuid(),
                'enabled' => fake()->boolean(),
                'deduction' => fake()->numberBetween(0,100),
            ]);
        }
    }
}
