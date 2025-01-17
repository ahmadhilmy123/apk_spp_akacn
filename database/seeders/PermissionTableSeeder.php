<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $permissions = [
            'view_users',
            'add_users',
            'edit_users',
            'delete_users',

            'view_roles',
            'add_roles',
            'edit_roles',
            'delete_roles',

            'view_tahun_ajaran',
            'add_tahun_ajaran',
            'edit_tahun_ajaran',
            'delete_tahun_ajaran',

            'view_prodi',
            'add_prodi',
            'edit_prodi',
            'delete_prodi',

            'view_semester',
            'add_semester',
            'edit_semester',
            'delete_semester',

            'view_biaya',
            'add_biaya',
            'edit_biaya',
            'delete_biaya',

            'view_kelola_pembayaran',
            'edit_kelola_pembayaran',

            'view_pembayaran',
            'add_pembayaran',
            'edit_pembayaran',
            'delete_pembayaran',
        ];

        foreach ($permissions as $permission) {
            Permission::create(['name' => $permission]);
       }
    }
}
