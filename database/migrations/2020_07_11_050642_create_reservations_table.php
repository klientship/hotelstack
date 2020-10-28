<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReservationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reservations', function (Blueprint $table) {
            $table->id();
            $table->string('uid')->unique();
            $table->string('oyo_id')->nullable();
            $table->boolean('active')->default(1);
            $table->boolean('checked_in')->default(0);
            $table->boolean('checked_out')->default(0);    
            $table->boolean('no_show')->default(0);    
            $table->boolean('invoice')->default(0);    
            $table->integer('adults')->default(1);
            $table->integer('kids')->default(0);
            $table->dateTime('check_in');
            $table->dateTime('check_out');
            $table->double('total', 8, 2)->default(0);
            $table->double('discount', 8, 2)->default(0);
            $table->unsignedBigInteger('guest_id');
            $table->integer('number_of_room')->default(1);
            $table->enum('status',['PENDING','CANCEL','SUCCESS'])->default('PENDING');
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
        Schema::dropIfExists('reservations');
    }
}
