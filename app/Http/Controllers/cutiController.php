<?php

namespace App\Http\Controllers;

use App\Models\cuti;
use App\Models\Employee;
use App\Models\Unit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class cutiController extends Controller
{
    public function index()
{
    $user= Auth::user()->uuid;//nyokot data nu login//
    $cuti = cuti::where('uuid_karyawan', $user)->get();
    
    return view('cuti.index', compact('cuti'));
}
public function ajukancuti()
{
    
    $employees = Employee::where('uuid','=',Session::get('uuid'))->first(); 
    $units = Unit::where('id', '>', 1)->get();
    $employees = Employee::where('id_unit','=',$employees->id_unit)
    ->where('uuid','!=',$employees->uuid)
    ->get(); 
    return view('cuti.ajukancuti', compact('units', 'employees'));
}
public function input(Request $request){
    $cuti =$request->validate([
        "uuid_karyawan"=>"Required",
        "jenis_cuti"=>"Required",
        "jumlah"=>"Required",
        "karyawan_pengganti"=>"Required",
        "keterangan"=>"Required",
        
        ]);
        $cuti['approved_pengganti'] = null;
        $cuti['status'] = 0;
        $cuti['tanggal'] = date('Y-m-d');
        
        cuti::insert($cuti);
        // dd($cuti);
        session::flash('success','berhasil menambah data');
        return redirect('/cuti');
    }
    public function formupdatee($uuid_karyawan){
        $cuti = cuti::where('uuid_karyawan',$uuid_karyawan)->first();
        
        dd($cuti);
        return view('/cuti.updatecuti',compact('cuti'));
      }
    public function update(Request $request){
        $cuti =$request->validate([
            "uuid_karyawan"=>"Required",
            "jenis_cuti"=>"Required",
            "jumlah"=>"Required",
            "karyawan_pengganti"=>"Required",
            "keterangan"=>"Required",
            
            ]);
            $cuti['approved_pengganti'] = null;
            $cuti['status'] = 0;
            $cuti['tanggal'] = date('Y-m-d');
            $cuti = cuti::where('uuid_karyawan',$request->uuid_karyawan)->update($cuti);

            // dd($cuti);
            session::flash('success','berhasil menambah data');
            return redirect('/cuti');
        }
        

}
