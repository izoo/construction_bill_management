<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBillsDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bills_details', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('item');
            $table->integer('price');
            $table->integer('quantity');
            $table->string('ref_no');
            $table->integer('total_cost');
            $table->integer('balance');
            $table->integer('amount_paid');
            $table->integer('vat');
            $table->text('status');
            $table->string('due_date');
            $table->string('return_status')->nullable();
            $table->string('mode_payment')->nullable();
            $table->string('mpesa_code')->nullable();
            $table->string('clearing_date')->nullable();
            $table->string('posting_date')->nullable();
            $table->text('payment_clearance_status')->nullable();
            $table->integer('pending_bank_amount')->nullable();
            $table->integer('pending_bank_balances')->nullable();
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
        Schema::dropIfExists('bills_details');
    }
}
