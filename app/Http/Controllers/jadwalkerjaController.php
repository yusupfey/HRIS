<?php

namespace App\Http\Controllers;

use App\Models\employees;
use App\Models\jadwalkerja;
use App\Models\workscheadules;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class jadwalkerjaController extends Controller
{
    public function index(){
        $worksheadules = workscheadules :: get();
        return view('pages.shift.jadwalkerja',compact('worksheadules'));
        
    }

    public function pilihjamkerja(){
        return view('pages.shift.pilihjamkerja');
    }
    public function input(Request $Request){
        $workshedules =$Request->validate([
            "tanggal"=>"Required",
            "shift"=>"Required",
        ]);
        workscheadules::insert($workshedules);
        return redirect('/jadwalkerja');
    }
}
