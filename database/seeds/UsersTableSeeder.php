<?php

use Illuminate\Database\Seeder;
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
        User::create([
            'name' => 'srisai',
            'email' => 'admin@srisaipalace.com',
            'password' => 'Sri123#',
            'role' => 'admin'
        ]);
        User::create([
            'name' => 'srisai',
            'email' => 'admin@kalyani.com',
            'password' => 'Kalyani123#',
            'role' => 'admin'
        ]);
        User::create([
            'name' => 'whitehouseinn',
            'email' => 'admin@whitehouseinn.in',
            'password' => 'White123#',
            'role' => 'admin'
        ]);
        User::create([
            'name' => 'surya',
            'email' => 'admin@surya.com',
            'password' => 'Surya123#',
            'role' => 'admin'
        ]);
       
    }
}
