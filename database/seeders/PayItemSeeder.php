<?php

namespace Database\Seeders;

use App\Models\PayItem;
use Illuminate\Database\Seeder;

class PayItemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($x = 0; $x <= 10; $x++){
            PayItem::create([
                'amount' => fake()->randomFloat(2,1,200),
                'hours_worked' => fake()->randomFloat(2,1,200),
                'pay_rate' => fake()->randomFloat(2,1,200),
                'date' => fake()->date(),
                'external_id' => fake()->uuid(),
            ]);
        }
    }
}
