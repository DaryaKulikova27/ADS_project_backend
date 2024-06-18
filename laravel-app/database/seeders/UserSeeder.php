<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::factory()
            ->count(1)
            ->dispatcher()
            ->create();

        User::factory()
            ->count(5)
            ->withRole(1)
            ->create();

        User::factory()
            ->count(1)
            ->executor()
            ->create();

        User::factory()
            ->count(1)
            ->withRole(2)
            ->create();
    }
}
