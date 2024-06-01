<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Customer;
use App\Models\Works;
use Illuminate\Support\Str;

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

        Works::factory()->create([
            'work_external_id' => 'bca56BAveh',
            'name' => 'Водомерные узлы и водомеры',
            'price' => null,
            'parent' => null,
            'is_folder' => true
        ]);

        Works::factory()->create([
            'work_external_id' => Str::random(10),
            'name' => 'Замена крана',
            'price' => 500,
            'parent' => 'bca56BAveh',
            'is_folder' => false
        ]);

        Works::factory()->create([
            'work_external_id' => 'bca56BAvab',
            'name' => 'Техническое обслуживание', 
            'price' => null,
            'parent' => null,
            'is_folder' => true
        ]);

        Works::factory()->create([
            'work_external_id' => Str::random(10),
            'name' => 'Ремонт лифтов',
            'price' => 500,
            'parent' => 'bca56BAvab',
            'is_folder' => false
        ]);

        Works::factory()->create([
            'work_external_id' => Str::random(10),
            'name' => 'Ремонт систем отопления',
            'price' => 500,
            'parent' => 'bca56BAvab',
            'is_folder' => false
        ]);

        Works::factory()->create([
            'work_external_id' => Str::random(10),
            'name' => 'Ремонт водопровода',
            'price' => 500,
            'parent' => 'bca56BAvab',
            'is_folder' => false
        ]);

        Works::factory()->create([
            'work_external_id' => 'bca56BA777',
            'name' => 'Уборка и благоустройство',
            'price' => null,
            'parent' => null,
            'is_folder' => true
        ]);

        Works::factory()->create([
            'work_external_id' => 'bca56BA555',
            'name' => 'Уборка территории',
            'price' => null,
            'parent' => 'bca56BA777',
            'is_folder' => true
        ]);

        Works::factory()->create([
            'work_external_id' => Str::random(10),
            'name' => 'Снегоуборка',
            'price' => 2000,
            'parent' => 'bca56BA555',
            'is_folder' => false
        ]);


    }
}
