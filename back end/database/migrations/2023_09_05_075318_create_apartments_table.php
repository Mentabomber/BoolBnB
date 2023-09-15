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
        Schema::create('apartments', function (Blueprint $table) {
            $table->id();

            $table->tinyText('title')->nullable(false);
            $table->tinyInteger('rooms')->nullable(false)->unsigned();
            $table->tinyInteger('beds')->nullable(false)->unsigned();
            $table->tinyInteger('bathrooms')->nullable(false)->unsigned();
            $table->integer('square_meters')->nullable(false)->unsigned();
            $table->string('image')->nullable(false);
            $table->boolean('visible')->nullable(false)->default(false);

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
        Schema::dropIfExists('apartments');
    }
};
