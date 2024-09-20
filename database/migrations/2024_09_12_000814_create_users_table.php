<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');

            $table->enum('session',['Online','Offline'])->default('Offline');
            $table->enum('user_types',['Developer','Admin','District','Areas','Branch'])->nullable();

            $table->string('avatar')->nullable();
            $table->date('dob');
            $table->rememberToken();

            $table->unsignedBigInteger('user_group_id');
            $table->unsignedBigInteger('company_id')->nullable();
            $table->unsignedBigInteger('branch_id')->nullable();
            $table->unsignedBigInteger('district_code_id')->nullable();
            $table->unsignedBigInteger('area_code_id')->nullable();

            $table->foreign('user_group_id')->references('id')->on('tbl_user_groups')->onDelete('restrict')->onUpdate('cascade');
            $table->foreign('company_id')->references('id')->on('tbl_companies')->onDelete('restrict')->onUpdate('cascade');
            $table->foreign('branch_id')->references('id')->on('tbl_branches')->onDelete('restrict')->onUpdate('cascade');
            $table->foreign('district_code_id')->references('id')->on('tbl_districts')->onDelete('restrict')->onUpdate('cascade');
            $table->foreign('area_code_id')->references('id')->on('tbl_areas')->onDelete('restrict')->onUpdate('cascade');


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
        Schema::dropIfExists('users');
    }
}
