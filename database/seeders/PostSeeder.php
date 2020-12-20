<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class PostSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\Post::factory(5)->create(['user_id' => 1]);
        \App\Models\Post::factory(4)->create(['user_id' => 1]);
    }
}