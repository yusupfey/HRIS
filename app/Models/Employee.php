<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Employee extends Model
{
    use HasFactory;
    protected $table = 'employees';

    protected $fillable = [
        'name', 'DOB', 'tempat_lahir', 'alamat', 'jenis_kelamin', 'inactive_date','uuid','no_telp'
    ];

    // protected static function boot()
    // {
    //     parent::boot();

    //     static::creating(function ($model) {
    //         $model->uuid = substr((string) Str::uuid(), 0, 16);
    //     });
    // }
    // Model Employee
public function workschedules()
{
    return $this->hasMany(workscheadules::class, 'uuid_employees', 'uuid');
}

// Model WorkSchedule
public function shift()
{
    return $this->belongsTo(Shift::class);
}
public function unit()
{
    return $this->belongsTo(Unit::class, 'id_unit'); // Sesuaikan dengan relasi Anda
}

}
