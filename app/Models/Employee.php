<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Employee extends Model
{
    use HasFactory;

    protected $fillable = [
        'uuid', 'name', 'DOB', 'tempat_lahir', 'alamat', 'jenis_kelamin', 'inactive_date'
    ];

    // protected static function boot()
    // {
    //     parent::boot();

    //     static::creating(function ($model) {
    //         $model->uuid = substr((string) Str::uuid(), 0, 16);
    //     });
    // }
}
