<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

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
            $table->decimal('amount', 24, 8);
            $table->string('address');
            $table->string('dest_tag')->nullable();
            $table->integer('confirms_needed');
            $table->integer('timeout');
            $table->string('checkout_url');
            $table->string('status_url');
            $table->string('qrcode_url');
            $table->string('api_status')->nullable();
            $table->string('api_status_text')->nullable();
            $table->string('amount2')->nullable();
            $table->string('status_history')->nullable();
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
