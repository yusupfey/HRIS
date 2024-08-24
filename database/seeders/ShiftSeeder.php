<?php

namespace Database\Seeders;

use App\Models\shift;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ShiftSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    protected $shift = [
        [
            'name'=>"Pagi (Poli)",
            "jam"=>"08:00:00",
            "inactive_date"=>null,
            "checkin_time"=>"08:00:00",
            "checkout_time"=>"15:00:00"
        ],
        [
            'name'=>"Middle Jam 10 (Poli)",
            "jam"=>"10:00:00",
            "inactive_date"=>null,
            "checkin_time"=>"10:00:00",
            "checkout_time"=>"05:00:00"
        ],
        [
            'name'=>"Sore (Poli)",
            "jam"=>"14:00:00",
            "inactive_date"=>null,
            "checkin_time"=>"14:00:00",
            "checkout_time"=>"21:00:00"
        ],
    ];
    public function run(): void
    {
        shift::insert($this->shift);
    }
}
