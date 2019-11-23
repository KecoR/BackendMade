<?php

use Illuminate\Database\Seeder;

class AdministratorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $role = new \App\Role;
        $role->role_desc = "Administrator";
        $role->save();

        $admin = new \App\User;
        $admin->email = "admin@admin.com";
        $admin->name = "Administrator";
        $admin->password = \Hash::make("123456");
        $admin->tgl_lahir = "2019-01-01";
        $admin->telp = "021123123123";
        $admin->alamat = "Jalan Administrator";
        $admin->umur = "25";
        $admin->jenis_kel = "Laki-Laki";
        $admin->role_id = "1";

        $admin->save();

        $this->command->info("User created");
    }
}
