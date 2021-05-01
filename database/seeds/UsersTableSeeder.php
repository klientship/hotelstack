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
            'name' => 'va',
            'email' => 'admin@vawebsites.in',
            'password' => 'VA123#',
            'role' => 'admin'
        ]);
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

        User::create([
            'name' => 'saiarya',
            'email' => 'admin@saiarya.com',
            'password' => 'Saiarya123#',
            'role' => 'admin'
        ]);

        User::create([
            'name' => 'padma',
            'email' => 'admin@hotelpadmaindia.com',
            'password' => 'Padma123#',
            'role' => 'admin'
        ]);
        User::create([
            'name' => 'summer sands',
            'email' => 'admin@summersands.in',
            'password' => 'Summer123#',
            'role' => 'admin'
        ]);
        User::create([
            'name' => 'Vedantabiz',
            'email' => 'admin@vedantabiz.com',
            'password' => 'Vedanta123#',
            'role' => 'admin'
        ]);
       
    }
}
