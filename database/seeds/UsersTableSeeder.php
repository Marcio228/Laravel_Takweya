<?php

use Cartalyst\Sentinel\Native\Facades\Sentinel;
use Illuminate\Database\Seeder;
use App\Profile;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = Sentinel::registerAndActivate([
            'first_name' => 'Admin',
            'last_name' => 'Admin',
            'email' => 'admin@gmail.com',
            'password' => 'admin777'
        ]);

        $role = Sentinel::findRoleBySlug('admin');
        $role->users()->attach($user);
    }
}