<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCoinpaymentsTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('coinpayments_transactions', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('txn_id');
            $table->decimal('amount', 8, 24);
            $table->string('address');
            $table->string('dest_tag');
            $table->integer('confirms_needed');
            $table->integer('timeout');
            $table->string('checkout_url');
            $table->string('status_url');
            $table->string('qrcode_url');
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
        Schema::dropIfExists('coinpayments_transactions');
    }
}
