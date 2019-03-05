<?php
/**
 * Created by PhpStorm.
 * User: eggy
 * Date: 10/24/18
 * Time: 7:12 PM
 */

// Home
Breadcrumbs::for('home', function ($trail) {
    $trail->push('Home', route('home'));
});

//user
Breadcrumbs::for('user', function ($trail) {
    $trail->parent('home');
    $trail->push('Pengguna', route('user.index'));
});

Breadcrumbs::for('user.create', function ($trail) {
    $trail->parent('user');
    $trail->push('Tambah Pengguna');
});

Breadcrumbs::for('user.edit', function ($trail) {
    $trail->parent('user');
    $trail->push('Ubah Pengguna');
});

Breadcrumbs::for('user.show', function ($trail) {
    $trail->parent('user');
    $trail->push('Detail Pengguna');
});

//role
Breadcrumbs::for('role', function ($trail) {
    $trail->parent('home');
    $trail->push('Role', route('role.index'));
});

Breadcrumbs::for('role.create', function ($trail) {
    $trail->parent('role');
    $trail->push('Tambah Role');
});

Breadcrumbs::for('role.edit', function ($trail) {
    $trail->parent('role');
    $trail->push('Ubah Role');
});

Breadcrumbs::for('role.show', function ($trail) {
    $trail->parent('role');
    $trail->push('Detail Role');
});

//tourism
Breadcrumbs::for('tourism', function ($trail) {
    $trail->parent('home');
    $trail->push('Destinasi', route('tourism.index'));
});

Breadcrumbs::for('tourism.prov', function ($trail) {
    $tourism = \App\Models\Tourism::withoutGlobalScopes()->find(\request()->segment(2));
    $trail->parent('tourism');
    $trail->push($tourism->province->name, route('tourism.index', ['province' => $tourism->province_id]));
});

Breadcrumbs::for('tourism.create', function ($trail) {
    $trail->parent('tourism');
    $trail->push('Tambah Role');
});

Breadcrumbs::for('tourism.edit', function ($trail) {
    $tourism = \App\Models\Tourism::withoutGlobalScopes()->find(\request()->segment(2));
    $trail->parent('tourism.prov');
    $trail->push($tourism->name);
});

Breadcrumbs::for('tourism.show', function ($trail) {
    $trail->parent('role');
    $trail->push('Detail Role');
});