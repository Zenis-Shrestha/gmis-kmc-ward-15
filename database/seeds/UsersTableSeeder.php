<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use App\Role;
use App\User;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        $role = Role::create([
            'name' => 'super-admin',
            'display_name' => 'Super Admin'
        ]);

        $user = User::create([
            'name' => 'Karan Bajracharya',
            'email' => 'karan@biztechnepal.com',
        	'password' => bcrypt('admin')
        ]);

        $user->attachRole($role);

        Model::reguard();
    }
}
