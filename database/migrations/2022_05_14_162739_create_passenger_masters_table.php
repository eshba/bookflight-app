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
        Schema::create('passenger_masters', function (Blueprint $table) {
            $table->integer('id')->from(1000)->autoIncrement();
			$table->string('name',100)->nullable($value = false);
			$table->string('sex',10)->nullable($value = false);
			$table->integer('age')->nullable();
			$table->string('email',100)->nullable($value = false)->unique();
			$table->integer('phone')->nullable($value = false)->unique();
			$table->tinyInteger('isregisterd')->default(1);
			$table->timestamp('created_at', $precision = 0)->useCurrent();
        });
		
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('passenger_masters');
    }
};
