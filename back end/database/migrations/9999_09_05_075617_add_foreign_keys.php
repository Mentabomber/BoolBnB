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
        Schema::table('apartments', function (Blueprint $table) {
            $table->foreignId('user_id')->constrained();
        });
        Schema::table('addresses', function (Blueprint $table) {
                $table->foreignId('apartment_id')->constrained();
        });
        Schema::table('messages', function (Blueprint $table) {
                $table->foreignId('apartment_id')->constrained();
        });
        Schema::table('visits', function (Blueprint $table) {
                $table->foreignId('apartment_id')->constrained();
        });
        Schema::table('apartment_sponsorship', function (Blueprint $table) {
                $table->foreignId('apartment_id')->constrained();
                $table->foreignId('sponsorship_id')->constrained();
        });
        Schema::table('apartment_service', function (Blueprint $table) {
                $table->foreignId('apartment_id')->constrained();
                $table->foreignId('service_id')->constrained();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
          Schema::table('apartment_sponsorship', function (Blueprint $table) {
               $table -> dropForeign('apartment_sponsorship_apartment_id_foreign');
               $table -> dropForeign('apartment_sponsorship_sponsorship_id_foreign');
               $table -> dropColumn('apartment_id');
               $table -> dropColumn('sponsorship_id');
          });
          Schema::table('apartment_service', function (Blueprint $table) {
            $table -> dropForeign('apartment_service_apartment_id_foreign');       
            $table -> dropForeign('apartment_service_service_id_foreign');
            $table -> dropColumn('apartment_id');
            $table -> dropColumn('service_id');
          });
          Schema::table('apartments', function (Blueprint $table) {
               $table -> dropForeign('apartments_user_id_foreign');
               $table -> dropColumn('user_id');
          });
          Schema::table('addresses', function (Blueprint $table) {
               $table -> dropForeign('addresses_apartment_id_foreign');
               $table -> dropColumn('apartment_id');
          });
          Schema::table('messages', function (Blueprint $table) {
               $table -> dropForeign('messages_apartment_id_foreign');
               $table -> dropColumn('apartment_id');
          });
          Schema::table('visits', function (Blueprint $table) {
               $table -> dropForeign('visits_apartment_id_foreign');
               $table -> dropColumn('apartment_id');
          });

    }
};
