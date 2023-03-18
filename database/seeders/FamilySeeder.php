<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

// family model
use App\Models\Family;


class FamilySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $createBudi = Family::create([
            'name' => 'Budi',
            'gender' => 'L',
        ]);

        // budi family
        $createDedi = Family::create([
            'name' => 'Dedi',
            'parent_id' => $createBudi->id,
            'gender' => 'L',
        ]);

        $createDodi = Family::create([
            'name' => 'Dodi',
            'parent_id' => $createBudi->id,
            'gender' => 'L',
        ]);

        $createDede = Family::create([
            'name' => 'Dede',
            'parent_id' => $createBudi->id,
            'gender' => 'L',
        ]);

        $createDewi = Family::create([
            'name' => 'Dewi',
            'parent_id' => $createBudi->id,
            'gender' => 'P',
        ]);

        // dedi family
        Family::create([
            'name' => 'Feri',
            'parent_id' => $createDedi->id,
            'gender' => 'L'
        ]);

        Family::create([
            'name' => 'Farah',
            'parent_id' => $createDedi->id,
            'gender' => 'P'
        ]);

        // dodi family
        Family::create([
            'name' => 'Gugus',
            'parent_id' => $createDodi->id,
            'gender' => 'L'
        ]);

        Family::create([
            'name' => 'Gandi',
            'parent_id' => $createDodi->id,
            'gender' => 'L'
        ]);

        // dede family
        Family::create([
            'name' => 'Hani',
            'parent_id' => $createDede->id,
            'gender' => 'P'
        ]);

        Family::create([
            'name' => 'Hana',
            'parent_id' => $createDede->id,
            'gender' => 'P'
        ]);
    }
}
