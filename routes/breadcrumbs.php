<?php // routes/breadcrumbs.php

// Note: Laravel will automatically resolve `Breadcrumbs::` without
// this import. This is nice for IDE syntax and refactoring.
use Diglactic\Breadcrumbs\Breadcrumbs;

// This import is also not required, and you could replace `BreadcrumbTrail $trail`
//  with `$trail`. This is nice for IDE type checking and completion.
use Diglactic\Breadcrumbs\Generator as BreadcrumbTrail;

// Home
Breadcrumbs::for('home', function (BreadcrumbTrail $trail) {
    $trail->push('Home', route('home'));
});

// Home > Items
Breadcrumbs::for('items', function (BreadcrumbTrail $trail) {
    $trail->parent('home');
    $trail->push('Barang', route('items.index'));
});
// Home > Items > [Create]
Breadcrumbs::for('create_item', function (BreadcrumbTrail $trail) {
    $trail->parent('items');
    $trail->push('Buat Barang', route('items.create'));
});
// Home > Items > [Edit]
Breadcrumbs::for('edit_item', function (BreadcrumbTrail $trail, $item) {
    $trail->parent('items');
    $trail->push("Edit : {$item->name}", route('items.edit', $item));
});

// Home > Users
Breadcrumbs::for('users', function (BreadcrumbTrail $trail) {
    $trail->parent('home');
    $trail->push('Pengguna', route('users.index'));
});
// Home > Users > [Create]
Breadcrumbs::for('create_user', function (BreadcrumbTrail $trail) {
    $trail->parent('users');
    $trail->push('Buat Pengguna', route('users.create'));
});
// Home > Users > [Edit]
Breadcrumbs::for('edit_user', function (BreadcrumbTrail $trail, $user) {
    $trail->parent('users');
    $trail->push("Edit : {$user->name}", route('users.edit', $user));
});

// Home > Roles
Breadcrumbs::for('roles', function (BreadcrumbTrail $trail) {
    $trail->parent('home');
    $trail->push('Role', route('roles.index'));
});
// Home > Roles > [Create]
Breadcrumbs::for('create_role', function (BreadcrumbTrail $trail) {
    $trail->parent('roles');
    $trail->push('Buat Role', route('roles.create'));
});
// Home > Roles > [Edit]
Breadcrumbs::for('edit_role', function (BreadcrumbTrail $trail, $role) {
    $trail->parent('roles');
    $trail->push("Edit : {$role->name}", route('roles.edit', $role));
});

