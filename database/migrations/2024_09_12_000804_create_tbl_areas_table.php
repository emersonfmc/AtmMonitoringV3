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
        Schema::create('tbl_areas', function (Blueprint $table) {
            $table->id();
            $table->string('area_no')->nullable();
            $table->string('area_name')->nullable();
            $table->string('email')->nullable();
            $table->unsignedBigInteger('district_id')->nullable();
            $table->unsignedBigInteger('company_id')->nullable();
            $table->foreign('district_id')->references('id')->on('tbl_districts')->onDelete('restrict')->onUpdate('cascade');
            $table->foreign('company_id')->references('id')->on('tbl_companies')->onDelete('restrict')->onUpdate('cascade');
            $table->string('status')->nullable();
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
        Schema::dropIfExists('tbl_areas');
    }
};
