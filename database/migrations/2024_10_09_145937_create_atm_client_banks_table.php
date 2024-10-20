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
            $table->unsignedBigInteger('bank_id')->nullable();
            $table->unsignedBigInteger('collection_date_id')->nullable();
            $table->string('transaction_number')->unique()->nullable();
            $table->string('bank_account_no')->unique()->nullable();
            $table->string('passbook_serial_no')->unique()->nullable();
            $table->integer('cash_box_no')->nullable();
            $table->integer('safekeep_cash_box_no')->nullable();
            $table->integer('pin_no')->nullable();
            $table->enum('atm_status',['old','new'])->nullable();
            $table->enum('atm_type',['ATM','Passbook','Sim Card'])->nullable();
            $table->string('location')->nullable();
            $table->date('expiration_date')->nullable();

            // Set foreign key relationships and use onDelete('set null') for cascading null on delete
            $table->foreign('bank_id')->references('id')->on('data_bank_lists')->onDelete('set null')->onUpdate('cascade');
            $table->foreign('collection_date_id')->references('id')->on('data_collection_dates')->onDelete('set null')->onUpdate('cascade');
            $table->foreign('client_information_id')->references('id')->on('client_information')->onDelete('set null')->onUpdate('cascade');

            $table->softDeletes();
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
