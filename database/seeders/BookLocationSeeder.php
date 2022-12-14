<?php

namespace Database\Seeders;

use App\Models\Booklocation;
use Illuminate\Database\Seeder;

class BookLocationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Booklocation::create([
            'name' => 'Sosial'
        ]);

        Booklocation::create([
            'name' => 'Politik'
        ]);

        Booklocation::create([
            'name' => 'Self Improvement'
        ]);

        Booklocation::create([
            'name' => 'Teknologi'
        ]);

        Booklocation::create([
            'name' => 'Fiksi'
        ]);
    }
}
