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
        Schema::create('client_information', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('branch_id');
            $table->string('pension_number')->unique();
            $table->string('pension_type', 255)->nullable();  // Match length with parent (can rename to 'pension_name' for consistency)
            $table->enum('pension_account_type', ['SSS', 'GSIS'])->nullable();
            $table->string('first_name')->nullable();
            $table->string('middle_name')->nullable();
            $table->string('last_name')->nullable();
            $table->string('suffix')->nullable();
            $table->date('birth_date')->nullable();

            // Foreign key constraints
            // $table->foreign('pension_type')->references('pension_name')->on('data_pension_types_lists')->onDelete('restrict')->onUpdate('cascade');  // Reference 'pension_name' now
            // $table->foreign('branch_id')->references('id')->on('branches')->onDelete('restrict')->onUpdate('cascade');

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
        Schema::dropIfExists('client_information');
    }
};
