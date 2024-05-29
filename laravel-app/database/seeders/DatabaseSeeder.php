<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Customer;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            CustomerSeeder::class,
            UserSeeder::class
        ]);
    }
}
