<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRotatorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rotators', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->integer('category');
            $table->timestamps();
        });

        Schema::create('url_rotator', function (Blueprint $table) {
            $table->id();
            $table->integer('url_id');
            $table->integer('rotator_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('rotators');
        Schema::dropIfExists('url_rotator');
    }
}
