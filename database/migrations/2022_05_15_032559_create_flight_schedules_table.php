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
        Schema::create('flight_schedules', function (Blueprint $table) {
            $table->integer('id')->autoIncrement();
			$table->integer('flightid')->nullable($value = false);
			$table->string('dept_time',50)->nullable($value = false);
			$table->string('arrival_time',50)->nullable($value = false);
			$table->integer('day')->nullable($value = false);
			$table->integer('vacantseats')->default(180);
			$table->tinyInteger('isreturn')->default(2);
        });
		
		for($i=1;$i<6;$i++) {
			DB::table('flight_schedules')->insert(
				array([
					'flightid' => 1000,
					'dept_time' => '09:00',
					'arrival_time' => '11:00',
					'day' => $i,
					'isreturn' => 2
				],[
					'flightid' => 1000,
					'dept_time' => '12:00',
					'arrival_time' => '14:00',
					'day' => $i,
					'isreturn' => 1
				],[
					'flightid' => 1000,
					'dept_time' => '15:00',
					'arrival_time' => '17:00',
					'day' => $i,
					'isreturn' => 2
				],[
					'flightid' => 1000,
					'dept_time' => '18:00',
					'arrival_time' => '20:00',
					'day' => $i,
					'isreturn' => 1
				] 
				)
			);
		}
		
		for($i=2;$i<8;$i+=2) {
			DB::table('flight_schedules')->insert(
				array([
					'flightid' => 1001,
					'dept_time' => '06:00',
					'arrival_time' => '07:00',
					'day' => $i,
					'isreturn' => 1
				],[
					'flightid' => 1001,
					'dept_time' => '08:00',
					'arrival_time' => '09:00',
					'day' => $i,
					'isreturn' => 2
				],[
					'flightid' => 1001,
					'dept_time' => '10:00',
					'arrival_time' => '11:00',
					'day' => $i,
					'isreturn' => 1
				],[
					'flightid' => 1001,
					'dept_time' => '12:00',
					'arrival_time' => '13:00',
					'day' => $i,
					'isreturn' => 2
				],[
					'flightid' => 1001,
					'dept_time' => '14:00',
					'arrival_time' => '15:00',
					'day' => $i,
					'isreturn' => 1
				] 
				)
			);
		}
		
		for($i=4;$i<8;$i++){
			DB::table('flight_schedules')->insert(
				array([
					'flightid' => 1002,
					'dept_time' => '11:00',
					'arrival_time' => '14:00',
					'day' => $i,
					'isreturn' => 2
				],[
					'flightid' => 1002,
					'dept_time' => '15:00',
					'arrival_time' => '18:00',
					'day' => $i,
					'isreturn' => 1
				],[
					'flightid' => 1002,
					'dept_time' => '19:00',
					'arrival_time' => '21:00',
					'day' => $i,
					'isreturn' => 2
				]
				)
			);
		}
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('flight_schedules');
    }
};
