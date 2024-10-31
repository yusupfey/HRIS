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
    
    public function workschedules()
{
    return $this->belongsTo(workscheadules::class, 'uuid_employees', 'uuid');
}
public function shift()
{
    return $this->belongsTo(Shift::class, 'shift_id');
}

// Model WorkSchedule
// public function shift()
// {
//     return $this->belongsTo(Shift::class);
// }


}
