<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('flight_bookings', function (Blueprint $table) {
            $table->integer('id')->autoIncrement();
			$table->integer('flightschduleid')->nullable($value = false);
			$table->integer('passengerid')->nullable($value = false);
			$table->integer('seat')->nullable();
			$table->integer('bookingprice')->nullable();
			$table->tinyInteger('isconfirmed')->default(1);
			$table->timestamp('booked_at', $precision = 0)->useCurrent();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('flight_bookings');
    }
};
