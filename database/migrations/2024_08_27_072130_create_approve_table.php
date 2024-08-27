<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('approve', function (Blueprint $table) {
            $table->id();
            $table->integer('id_permohonan');
            $table->integer('jenis_permohonan'); //1. cuti, 2, izin, 3, tuker dines
            $table->char('uuid_atasan', 36);
            $table->integer('approve')->nullable(); //1 yes, 2.no
            $table->dateTime('approve_date')->nullable();
            $table->text('keterangan')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('approve');
    }
};
