<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
// FAMILY SEEDER
use Database\Seeders\FamilySeeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(FamilySeeder::class);

        // \App\Models\User::factory(10)->create();
    }
}
