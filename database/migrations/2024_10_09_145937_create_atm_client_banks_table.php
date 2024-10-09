<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('atm_client_banks', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('client_information_id')->nullable();
            $table->string('transaction_number')->unique()->nullable();
            $table->string('bank_account_no')->unique()->nullable();
            $table->string('passbook_serial_no')->unique()->nullable();
            $table->string('bank_name')->nullable();
            $table->integer('cash_box_no')->nullable();
            $table->integer('safekeep_cash_box_no')->nullable();
            $table->string('collection_date')->nullable();
            $table->integer('pin_no')->nullable();
            $table->enum('atm_status',['old','new'])->nullable();
            $table->enum('atm_type',['ATM','Passbook','Sim Card'])->nullable();
            $table->integer('location')->nullable();

            // $table->foreign('bank_name')->references('bank_name')->on('data_bank_lists')->onDelete('restrict')->onUpdate('cascade');
            // $table->foreign('collection_date')->references('collection_date')->on('data_collection_dates')->onDelete('restrict')->onUpdate('cascade');
            // $table->foreign('client_information_id')->references('id')->on('client_information')->onDelete('restrict')->onUpdate('cascade');

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
        Schema::dropIfExists('atm_client_banks');
    }
};
