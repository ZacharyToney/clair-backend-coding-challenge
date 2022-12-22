<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        for ($x = 0; $x <= 10; $x++){
            User::create([
                'name' => fake()->company(),
                'email' => fake()->email(),
                'password' => \Hash::make(fake()->password()),
                'external_id' => fake()->uuid()
            ]);
        }
    }
}
