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
        Schema::create('tbl_branches', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('district_id')->nullable();
            $table->unsignedBigInteger('area_id')->nullable();

            $table->string('branch_abbreviation')->nullable();
            $table->string('branch_location')->nullable();
            $table->string('branch_head')->nullable();

            $table->unsignedBigInteger('company_id');

            $table->foreign('district_id')->references('id')->on('tbl_districts')->onDelete('restrict')->onUpdate('cascade');
            $table->foreign('area_id')->references('id')->on('tbl_areas')->onDelete('restrict')->onUpdate('cascade');
            $table->foreign('company_id')->references('id')->on('tbl_companies')->onDelete('restrict')->onUpdate('cascade');

            $table->string('status');

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
        Schema::dropIfExists('tbl_branches');
    }
};
