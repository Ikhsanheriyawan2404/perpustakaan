<?php

namespace Database\Seeders;

use App\Models\Fine;
use Illuminate\Database\Seeder;

class FineSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Fine::create([
            'nominal' => 0,
        ]);
    }
}
