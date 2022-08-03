<?php

namespace Database\Seeders;

use Database\Factories\ItemFactory;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            PermissionSeeder::class,
            RoleSeeder::class,
            UserSeeder::class,
            BookLocationSeeder::class,
            MemberSeeder::class,
            BookSeeder::class,
        ]);
        // \App\Models\Book::factory(100)->create();
    }
}
