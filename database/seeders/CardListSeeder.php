<?php

namespace Database\Seeders;

use App\Models\CardList;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CardListSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        CardList::create([
           'name' => 'Todo',
           'position' => 1,
        ]);

        CardList::create([
            'name' => 'In progress',
            'position' => 2,
        ]);
    }
}
