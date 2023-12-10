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
   
        $role->syncPermissions([1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21,22,23,24,25,26]);

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
   
        $role_petugas->syncPermissions([25,26]);

        $petugas->assignRole([$role_petugas->id]);

        // User mahasiswa
        $role_mhs = Role::create([
            'name' => 'mahasiswa',
            'guard_name' => 'web'
        ]);
   
        $role_mhs->syncPermissions([27,28,29,30]);
    }
}
