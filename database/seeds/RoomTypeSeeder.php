<?php

use Illuminate\Database\Seeder;
use App\RoomType;

class RoomTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        RoomType::create([
            'title' => 'Superior Room',
            'short_code' => 'SR',
            'description' => 'Superior Room',
            'base_price' => '999',
            'ac_price' => '1000',
            'other_price' => '1000',
        ]);

        RoomType::create([
            'title' => 'Deluxe Room',
            'short_code' => 'DR',
            'description' => 'Deluxe Room',
            'base_price' => '1000',
            'ac_price' => '1000',
            'other_price' => '1500',
        ]);
    }
}
