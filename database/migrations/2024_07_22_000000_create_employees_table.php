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
            $table->char('uuid',36)->unique();
            $table->string('name');
            $table->date('DOB');
            $table->string('tempat_lahir', 100);
            $table->integer('jenis_kelamin');
            $table->text('alamat');
            $table->char('no_telp');
            $table->char('id_unit');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('employees');
    }
};
