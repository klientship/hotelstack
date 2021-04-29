<?php

use Illuminate\Database\Seeder;
use App\UidCount;

class UidCountSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        UidCount::create([
          'count' => 6651
        ]);
    }
}
