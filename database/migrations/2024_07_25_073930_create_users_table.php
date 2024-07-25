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
            $table->string('uuid_employees', 16);
            $table->string('username');
            $table->text('password');
            $table->string('role');
            $table->timestamp('inactive_date')->nullable();
            $table->timestamps();

            // Foreign key constraint
            $table->foreign('uuid_employees')->references('uuid')->on('employees');
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
