<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // User Admin
        $admin = User::create([
            'name' => 'Admin',
            'email' => 'admin@gmail.com',
            'password' => bcrypt('000000')
        ]);

        $role = Role::create([
            'name' => 'admin',
            'guard_name' => 'web'
        ]);

        $permissions = Permission::pluck('id','id')->all();
   
        $role->syncPermissions($permissions);

        $admin->assignRole([$role->id]);

        // User Petugas
        $petugas = User::create([
            'name' => 'Petugas',
            'email' => 'petugas@gmail.com',
            'password' => bcrypt('000000')
        ]);

        $role_petugas = Role::create([
            'name' => 'petugas',
            'guard_name' => 'web'
        ]);
   
        $role_petugas->syncPermissions([]);

        $petugas->assignRole([$role_petugas->id]);

        // User mahasiswa
        $mahasiswa = User::create([
            'name' => 'Mahasiswa',
            'email' => 'mahasiswa@gmail.com',
            'password' => bcrypt('000000'),
        ]);

        $role_mhs = Role::create([
            'name' => 'mahasiswa',
            'guard_name' => 'web'
        ]);
   
        $role_mhs->syncPermissions([]);

        $mahasiswa->assignRole([$role_mhs->id]);
    }
}
