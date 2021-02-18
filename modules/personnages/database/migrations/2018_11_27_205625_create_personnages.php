<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;

class CreatePersonnages extends \Illuminate\Database\Migrations\Migration
{
    public function up()
    {
        Schema::create("personnages", function (Blueprint $table) {
            $table->increments("id");
            $table->timestamps();
            $table->softDeletes();

            $table->unsignedMediumInteger("owner_id")->nullable();
            $table->boolean("hide")->default(false);
            $table->boolean("current")->default(false);

            $table->string("name");
            $table->string("slug");
            $table->unsignedMediumInteger("age")->default(18);

            $table->string("job")->nullable();
            $table->string("title")->nullable();

            $table->boolean("active")->default(true);
            $table->boolean("isStaff")->default(false);
            $table->boolean("alive")->default(true);

            
            $table->text("bio")->nullable();
            $table->text('physical')->nullable();
            $table->text("signature")->nullable();
            $table->text("affections")->nullable();
            $table->text("aversions")->nullable();
            $table->string("location")->nullable();

            $table->boolean("hasForce")->default(false);
        });
    }

    public function down()
    {
        Schema::dropIfExists("personnages");
    }
}
