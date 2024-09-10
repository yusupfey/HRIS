<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class d_cuti extends Model
{
    use HasFactory;
    protected $guarded = [ 'id',];
    protected $table = 'd_cuti';
    protected $fillable = ['id_cuti', 'tanggal_cuti'];

}

