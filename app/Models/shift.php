<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class shift extends Model
{
    use HasFactory;
    protected $guarded = [
        'id'
    ];
    public function unit()
    {
        return $this->belongsTo(Unit::class, 'id_unit');
    }
    protected $fillable = [
        'name',
        'checkin_time',
        'checkout_time',
        'id_unit', // Pastikan ini ada di sini
    ];
}
