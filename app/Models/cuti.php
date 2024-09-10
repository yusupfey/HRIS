<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class cuti extends Model
{
    use HasFactory;
    protected $table = 'cuti';
    protected $guarded = [
        'id',
    ];
    protected $fillable = [
        'uuid_karyawan',
        'jenis_cuti',
        'jumlah',
        'tanggal',
        'karyawan_pengganti',
        'keterangan',
        'approved-pengganti',
        'status',
        'inactive_date',
    ];
}
