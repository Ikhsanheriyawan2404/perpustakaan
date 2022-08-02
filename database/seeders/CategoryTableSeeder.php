<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategoryTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Category::create([
            'name' => 'Joharudin',
        ]);

        Category::create([
            'name' => 'Baimiun',
        ]);

        Category::create([
            'name' => 'Wawais',
        ]);
    }
}
