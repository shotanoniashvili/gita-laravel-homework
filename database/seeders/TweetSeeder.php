<?php

namespace Database\Seeders;

use App\Models\Tweets\Tweet;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TweetSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach (User::all()->random(User::count() - rand(0, 5)) as $user) {
            for ($i = 0; $i < rand(0, 10); $i++) {
                $user->tweets()->save(new Tweet([
                    'user_id' => $user->id,
                    'content' => fake()->text(140)
                ]));
            }
        }
    }
}
