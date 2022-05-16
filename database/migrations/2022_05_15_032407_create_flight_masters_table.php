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
        Schema::create('flight_masters', function (Blueprint $table) {
            $table->integer('id')->from(1000)->autoIncrement();
			$table->string('name',100)->nullable($value = false);
			$table->string('location',100)->nullable($value = false);
			$table->integer('totalseats')->default(180);
			$table->integer('priceperseat')->default(3000);
        });
		
		DB::table('flight_masters')->insert(
			array([
				'name' => 'Qatar',
				'location' => 'Delhi'	
			],[
				'name' => 'Emirates',
				'location' => 'Kolkata'
			],[
				'name' => 'Vistara',
				'location' => 'Chennai'
			]
			)
		);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('flight_masters');
    }
};
