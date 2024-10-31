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
        Schema::create('ubahjadwal', function (Blueprint $table) {
            $table->id();
            
            $table->char('uuid_pemohon',36);
            $table->char('uuid_pengganti',36);
            $table->dateTime('tanggal_perubahan');
            $table->string('shift_awal');
            $table->string('shift_pengganti');
            $table->text('keterangan');
            $table->integer('status');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ubahjadwal');
    }
};
