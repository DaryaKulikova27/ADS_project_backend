<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // User::factory()->count(1)->withRole(0)->create();
        // User::factory()->count(5)->withRole(1)->create();
        // User::factory()->count(2)->withRole(2)->create();
        User::factory()->count(5)->create();
    }
}