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

            $table->tinytext('title')->nullable(false);
            $table->tinyint('rooms')->nullable(false)-> Check('rooms' > 0);
            $table->tinyint('beds')->nullable(false);
            $table->tinyint('bathrooms')->nullable(false);
            $table->int('square_meters')->nullable(false);
            $table->text('image')->nullable(false);
            $table->boolean('visible')->nullable(false);
            $table->int('user_id')->nullable(false);

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
