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
        Schema::create('cuti', function (Blueprint $table) {
            $table->id();
            $table->char('uuid_karyawan',36);
            $table->integer('jenis_cuti');
            $table->integer('jumlah');
            $table->dateTime('tanggal');
            $table->char('karyawan_pengganti',36);
            $table->dateTime('approved_pengganti')->nullable();
            $table->dateTime('keterangan');
            $table->integer('status');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cuti');
    }
};
