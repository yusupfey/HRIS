<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateIzinTable extends Migration
{
    /**
     * Jalankan migrasi.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('izin', function (Blueprint $table) {
            $table->id();
            $table->char('uuid_karyawan', 36);
            $table->time('start_time');
            $table->time('end_time');
            $table->text('alasan');
            $table->text('alamat');
            $table->char('notelpon', 255);
            $table->int('status');
            $table->dateTime('inactive_date')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Balikkan migrasi.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('izin');
    }
}
