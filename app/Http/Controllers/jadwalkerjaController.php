<?php

namespace App\Http\Controllers;

use App\Models\employees;
use App\Models\jadwalkerja;
use App\Models\shift;
use App\Models\workscheadules;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;


class jadwalkerjaController extends Controller
{
    public function index()
    {
        $worksheadules = DB::select("SELECT employees.name, worksheadules.tanggal,shifts.name as shift FROM `worksheadules` INNER JOIN employees ON worksheadules.uuid_employees = employees.uuid INNER JOIN shifts ON worksheadules.shift_id =shifts.id;");
        return view('pages.shift.jadwalkerja', compact('worksheadules'));
    }

    public function pilihjamkerja()
    {
        $shift = shift::get();
        $tahun = date('Y');
        $bulan = date('m');
        $calculate_date = cal_days_in_month(CAL_GREGORIAN, $bulan, $tahun);

        return view('pages.shift.pilihjamkerja', compact('shift','calculate_date','bulan', 'tahun'));
    }
    public function input(Request $Request)
    {
        $workshedules = $Request->validate([
            "tanggal" => "Required",
            "shift" => "Required",
        ]);
        
        workscheadules::insert($workshedules);
        return view('pages.shift.jadwalkerja', compact('tanggal'));
    }
}
