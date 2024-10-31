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
        Schema::table('sakit', function (Blueprint $table) {
            $table->char('uuid_karyawan',36)->nullable();
            
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('sakit', function (Blueprint $table) {
            $table->dropColumn('uuid_karyawan');
            
        });
    }
};
