<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('groups', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            $table->softDeletes();

            $table->string("name");
            $table->string("slug");
            $table->text("content")->nullable();
            $table->boolean("isPrivate")->default(false);
            $table->boolean("isSecret")->default(false);
            $table->boolean("isFaction")->default(false);
            $table->boolean("active")->default(true);
            $table->string("color")->nullable();
        });
    }
    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('groups');
    }
}