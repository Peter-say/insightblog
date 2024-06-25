<?php

namespace Database\Seeders;

use App\Models\BlogPost;
use App\Models\User;
use App\Models\ViewCount;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // $this->call(UserSeeder::class);
        // $this->call(BlogCategoryTableSeeder::class);
        // BlogPost::factory(15)->create();
        ViewCount::factory(10)->create();

       
    }
}
