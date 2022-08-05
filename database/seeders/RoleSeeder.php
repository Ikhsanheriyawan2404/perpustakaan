<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $superadmin = Role::create([
            'name' => 'Superadmin',
            'guard_name' => 'web'
        ]);

        $admin = Role::create([
            'name' => 'Admin',
            'guard_name' => 'web'
        ]);

        $superadmin->givePermissionTo([
            'user-list',
            'user-create',
            'user-edit',
            'user-delete',
            'role-list',
            'role-create',
            'role-edit',
            'role-delete',
            'book-module',
            'book-trash',
            'bookloan-module',
            'bookloan-trash',
            'booklocation-module',
            'member-module',
            'profil-module',
            'fine-module',
        ]);

        $admin->givePermissionTo([
            'book-module',
            'bookloan-module',
            'booklocation-module',
            'member-module',
        ]);
    }
}
