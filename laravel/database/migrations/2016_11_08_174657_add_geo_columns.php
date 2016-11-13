<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddGeoColumns extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users_info', function ($table) {
            $table->string('country_id');
        });

        Schema::table('users_info', function ($table) {
            $table->string('city_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users_info', function ($table) {
            $table->dropColumn('country_id');
        });

        Schema::table('users_info', function ($table) {
            $table->dropColumn('city_id');
        });
    }
}
