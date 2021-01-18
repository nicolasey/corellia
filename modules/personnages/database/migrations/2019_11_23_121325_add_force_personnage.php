<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddForcePersonnage extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table("personnages", function(Blueprint $table) {
            $table->string("location")->nullable();
            $table->boolean("hasForce")->default(false);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table("personnages", function (Blueprint $table) {
            $table->dropColumn("location");
            $table->dropColumn("hasForce");
        });
    }
}
