<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Izin extends Model
{

    protected $table = 'izin';
    protected $fillable = [
        'uuid_karyawan',
        'start_time',
        'end_time',
        'alasan',
        'alamat',
        'notelpon',
        'status',
        'inactive_date',
    ];

    protected $casts = [
        'start_time' => 'datetime:H:i',
        'end_time' => 'datetime:H:i',
        'inactive_date' => 'datetime:Y-m-d H:i:s',
    ];

}
