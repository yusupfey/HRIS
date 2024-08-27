<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\employees;
use App\Models\jadwalkerja;
use App\Models\shift;
use App\Models\workscheadules;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class jadwalkerjaController extends Controller
{
    public function index()
    {
        $data = Employee::where('uuid', Session::get('uuid'))->first();
        $worksheadules = DB::select("SELECT employees.*, units.name as Unit
        FROM employees
        INNER JOIN units ON units.id = employees.id_unit
        WHERE employees.id_unit = $data->id_unit");
        return view('pages.shift.jadwalkerja', compact('worksheadules'));
    }

    public function getjamkerja(Request $request){
        $data = DB::select("select * from worksheadules where uuid_employees='$request->uuid' and YEAR(tanggal)=$request->year and MONTH(tanggal)=$request->month");
        return $data;
    }

    public function pilihjamkerja()
    {
        $shift = shift::get();
        $tahun = date('Y');
        $bulan = date('m');
        
        $calculate_date = cal_days_in_month(CAL_GREGORIAN, $bulan, $tahun,);

        return view('pages.shift.pilihjamkerja', compact('shift','calculate_date','bulan', 'tahun'));
    }
    public function input(Request $Request)
    {
        $data = DB::select("select * from worksheadules where uuid_employees='$Request->uuid' and YEAR(tanggal)=$Request->year and MONTH(tanggal)=$Request->month");
        // dd($data);
       if (count($data)>0){
        // dd($data);
            foreach($data as $i=>$item){
                if($item->tanggal == $Request->tanggal[$i] && $Request->shift[$i] !==$item->shift_id){
                    $id =$item->id;
                    $workshedules['shift_id'] =$Request->shift[$i];
                    workscheadules::where('id', $id)->update($workshedules);
                    // dd($workshedules);
                }
            }
       }else{
           for ($i=0; $i < count($Request->tanggal); $i++) {
               $workshedules['tanggal'] =$Request->tanggal[$i];
               $workshedules['shift_id'] =$Request->shift[$i];
               $workshedules['uuid_employees'] =$Request->uuid;
               workscheadules::insert($workshedules);
           }
       }
       
        return redirect('/jadwalkerja');
    }
    
 }
     
