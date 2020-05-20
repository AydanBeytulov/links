<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFundsColumns extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('funds', function (Blueprint $table) {
            $table->string('checkout_url')->nullable();
            $table->string('status_url')->nullable();
            $table->string('qrcode_url')->nullable();
            $table->float('btc_price')->nullable();
            $table->string('pay_address')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('funds', function (Blueprint $table) {
            $table->dropColumn('checkout_url');
            $table->dropColumn('status_url');
            $table->dropColumn('qrcode_url');
            $table->dropColumn('btc_price');
            $table->dropColumn('pay_address');
        });
    }
}
