<?php

namespace Database\Seeders;

use App\Models\Menu;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MenuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    protected $menu = [
        ['header_id'=>null,'name'=>"Dashboard",'href'=>"/dashboard",'icon'=>'bi bi-grid','order'=>'0'],
        ['header_id'=>null,'name'=>"Master",'href'=>"#",'icon'=>'bi bi-menu-button-wide','order'=>'0'],
        ['header_id'=>"2",'name'=>"Karyawan",'href'=>"employees",'icon'=>'menu-link','order'=>'1'],
        ['header_id'=>"2",'name'=>"Menu",'href'=>"/master/menu",'icon'=>'menu-link','order'=>'1'],
        ['header_id'=>"2",'name'=>"shift",'href'=>"/shift",'icon'=>'menu-link','order'=>'1'],
        ['header_id'=>"2",'name'=>"Jadwal karyawan",'href'=>"/jadwalkerja",'icon'=>'menu-link','order'=>'1'],
        ['header_id'=>"2",'name'=>"Unit",'href'=>"/master/unit",'icon'=>'menu-link','order'=>'1'],
    ];
    public function run(): void
    {
        Menu::insert($this->menu);

    }
}
