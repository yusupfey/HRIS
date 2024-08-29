<?php

namespace App\Http\Controllers;

use App\Models\Approve;
use App\Models\cuti;
use App\Models\Employee;
use App\Models\Unit;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
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
    // $approve = Approve::where('uuid_atasan')->get();
    $units = Unit::where('id', '>', 1)->get();
    $employees = Employee::where('id_unit','=',$employees->id_unit)
    ->where('uuid','!=',$employees->uuid)
    ->get(); 
    return view('cuti.ajukancuti', compact('units','employees'));
}
public function input(Request $request){
    $cuti =$request->validate([
        "uuid_karyawan"=>"Required",
        "jenis_cuti"=>"Required",
        "jumlah"=>"Required",
        "karyawan_pengganti"=>"Required",
        "keterangan"=>"Required",
        "uuid_atasan"=>"Required"
        
        ]);
        $cuti['approved_pengganti'] = null;
        $cuti['status'] = 0;
        $cuti['tanggal'] = date('Y-m-d');
         
        
        cuti::insert($cuti);
        // dd($cuti);
        session::flash('success','berhasil menambah data');
        return redirect('/cuti');
    }
    public function formupdatee($id)
{
    $cuti = Cuti::find($id);
    

    $employees = Employee::where('uuid','=',Session::get('uuid'))->first(); 
    
    $cuti->tanggal = Carbon::parse($cuti->tanggal)->format('Y-m-d');
    // dd($cuti);
    $employees = Employee::where('id_unit','=',$employees->id_unit)
                            ->where('uuid','!=',$employees->uuid)
                            ->get(); 
    
                        //  dd($employees);
                         return view('cuti.updatecuti', compact('cuti', 'employees'));
}

public function update(Request $request, $id)
{
    $request->validate([
        'jenis_cuti' => 'required|string',
        'keterangan' => 'required|string',
        'jumlah' => 'required|integer',
        'tanggal' => 'required|date',
        'karyawan_pengganti' => 'required|string',
    ]);

    // Cari cuti berdasarkan id dan lakukan update
    $cuti = Cuti::findOrFail($id);
    $cuti->jenis_cuti = $request->jenis_cuti;
    $cuti->keterangan = $request->keterangan;
    $cuti->jumlah = $request->jumlah;
    $cuti->tanggal = $request->tanggal;
    $cuti->karyawan_pengganti = $request->karyawan_pengganti;
    $cuti->save();
    // dd($cuti);
    return redirect('/cuti');
}
        

}
