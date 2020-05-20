<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddSomeFields extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->enum('paid', ['unpaid', 'wait','payed'])->default('unpaid');
            $table->boolean('active')->default(false);
            $table->float('price')->nullable();
        });

        Schema::table('urls', function (Blueprint $table) {
            $table->integer('order_id')->nullable();
            $table->string('spoof_url')->nullable();
            $table->boolean('active')->default(false);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn('paid');
            $table->dropColumn('active');
            $table->dropColumn('price');
        });

        Schema::table('urls', function (Blueprint $table) {
            $table->dropColumn('order_id');
            $table->dropColumn('spoof_url');
            $table->dropColumn('active');
        });
    }
}
