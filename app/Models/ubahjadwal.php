<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ubahjadwal extends Model
{
    use HasFactory;
    protected $table = 'ubahjadwal';

    protected $fillable = [
        'uuid_pemohon',
        'uuid_pengganti',
        'tanggal_perubahan',
        'shift_awal',
        'shift_pengganti',
        'keterangan',
        'status',
    ];
}
