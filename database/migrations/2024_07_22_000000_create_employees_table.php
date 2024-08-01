<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('employees', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid', 16)->unique();
            $table->string('name');
            $table->date('DOB');
            $table->string('tempat_lahir', 100);
            $table->text('alamat');
            $table->integer('jenis_kelamin');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('employees');
    }
};
