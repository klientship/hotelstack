<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRoomTypesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('room_types', function (Blueprint $table) {
            $table->id();
            $table->string('title')->unique();
            $table->string('short_code')->unique();
            $table->longText('description')->nullable();
            $table->float('base_price',8,2)->default(0);
            $table->float('ac_price',8,2)->default(0);
            $table->float('other_price',8,2)->default(0);
            $table->float('tax_1',8,2)->default(0);
            $table->float('tax_2',8,2)->default(0);
            $table->boolean('status')->default(1);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('room_types');
    }
}
