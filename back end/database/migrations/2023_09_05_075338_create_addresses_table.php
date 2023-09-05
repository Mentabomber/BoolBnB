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
        Schema::create('addresses', function (Blueprint $table) {
            $table->id();

            $table->decimal('latitude', 8,6)->nullable(false);
            $table->decimal('longitude', 9,6)->nullable(false);
            $table->string('street', 64)->nullable(false);
            $table->integer('street_number')->nullable(false);
            $table->char('cap', 5)->nullable(false);
            $table->string('city', 32)->nullable(false);
            $table->string('province', 32)->nullable(false);
            $table->tinyInteger('floor');

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
        Schema::dropIfExists('addresses');
    }
};
