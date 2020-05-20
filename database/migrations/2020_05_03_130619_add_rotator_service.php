<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRotatorService extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('rotators', function (Blueprint $table) {
            $table->integer('service')->nullable();
            $table->dropColumn('category');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('rotators', function (Blueprint $table) {
            $table->dropColumn('service');
            $table->integer('category')->nullable();
        });
    }
}
