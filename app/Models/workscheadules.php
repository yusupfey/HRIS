<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class workscheadules extends Model
{
    use HasFactory; 
    protected $table ='worksheadules';
    protected $guarded = [
        'id'
    ];
}
