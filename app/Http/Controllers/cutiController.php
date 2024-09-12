<?php

namespace App\Http\Controllers;

use App\Models\Approve;
use App\Models\cuti;
use App\Models\d_cuti;
use App\Models\Employee;
use App\Models\Reference;
use App\Models\Unit;
use Illuminate\Routing\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class cutiController extends Controller
{
    public function index ()
    {
        $user= Auth::user()->uuid;//nyokot data nu login//
        $cuti = cuti::where('uuid_karyawan', $user)->get();
        // $cuti = cuti::join('employees', 'cuti.uuid_karyawan', '=', 'employees.uuid') // Asumsi kolom uuid_karyawan ada di tabel izin
        // ->select('employees.name','cuti.*')
        // ->get();
        // dd($cuti);

    return view('cuti.index', compact('cuti','user'));
    }
public function newformm()
{
    $uuid = Auth::user()->uuid;  
    $employees = Employee::where('uuid','=',Session::get('uuid'))->first(); 
    $karyawan_pengganti = Employee::where('id_unit','=',$employees->id_unit)
    ->where('uuid','!=',$employees->uuid)
    ->get(); 
    // $approve = Approve::where('uuid_atasan')->get();
    // $units = Unit::where('id', '>', 1)->get();
    // $employees = Employee::where('id_unit','=',$employees->id_unit)
    // ->where('uuid','!=',$employees->uuid)
    // ->get(); 
    $reference=DB::table('d_references')->where('reference_id', 1)->get();
    // dd($d_cuti);

    
    $employees= DB::table('employees as e')
    ->join('units as u', 'e.id_unit', '=', 'u.id')
    ->select('e.id AS employee_id', 'e.uuid', 'u.id AS unit_id', 'u.name AS unit_name', 'u.kepala_unit', 'u.id_head_unit')
    ->where('e.uuid', $uuid)
    ->first();

    // dd($employees);
    if ($employees) {
        // dd($employees);
        $units = DB::table('units as u')
            ->join('employees as e', 'e.uuid', '=', 'u.kepala_unit')
            ->select('e.name as nama_karyawan', 'u.*')
            ->where('u.id', '<=', $employees->id_head_unit + 1)
            ->where('u.id', '!=', 1)
            ->get();
            
            // dd($units);
        return view('cuti.ajukancuti', ['employees' => $karyawan_pengganti, 'units' => $units,'reference'=>$reference]);
    } else {
        return redirect()->back()->with('error', 'Data karyawan tidak ditemukan.');
    }
}
public function store(Request $request){
    $request->validate([
        "jenis_cuti"=>"Required",
        "jumlah"=>"Required",
        "karyawan_pengganti"=>"Required",
        "keterangan"=>"Required",

        ]);
        $request['approved_pengganti'] = null;
        $request['status'] = 0;
        $request['tanggal'] = date('Y-m-d');
        $request['tanggal_cuti'] = $request->tanggal_cuti;

        $uuid = Auth::user()->uuid;

        $employee = DB::table('employees')
            ->where('uuid', $uuid)
            ->first();
        

            
        if($employee){

            cuti::create([
                'uuid_karyawan' => $uuid,
                'jenis_cuti' => $request->input('jenis_cuti'),
                'jumlah' => $request->input('jumlah'),
                'tanggal' => $request->input('tanggal'),
                'karyawan_pengganti' => $request->input('karyawan_pengganti'),
                'keterangan' => $request->input('keterangan'),
                'approved_pengganti' => $request->input('approved_pengganti') ?: null,
                'status' => $request->input('status') ?? 0,
                

            ]);
                $cuti = cuti::latest()->first();
    
                    for ($i=0; $i < count($request->persetujuan); $i++) {
    
                        Approve::create([
                            'id_permohonan' => $cuti->id,
                            'jenis_permohonan' => 1,
                            'uuid_atasan' => $request->persetujuan[$i],
                        ]);
                     }

                    for ($i=0; $i < count($request->tanggal_cuti); $i++) {
                        if($request->tanggal_cuti[$i] !=null){
                            d_cuti::create([
                                'id_cuti'=> $cuti->id,
                                'tanggal_cuti'=>$request->tanggal_cuti[$i]
                            ]);
                        }
                     }

                    
                     return redirect()->route('cuti.index')->with('success', 'Izin berhasil dibuat.');
                    }else {
                        return redirect()->back()->with('error', 'Data karyawan tidak ditemukan.');
                        
        }  
    }
public function formupdatee($id)
{
   
    $cuti = Cuti::find($id);
    $d_cuti = d_cuti::where('id_cuti', $id)->get();
    $reference= DB::table('references')->get();
    $employee = Employee::where('uuid', '=', Session::get('uuid'))->first();
    $cuti->tanggal = Carbon::parse($cuti->tanggal)->format('Y-m-d');

    $employees = Employee::where('id_unit', '=', $employee->id_unit)
                        ->where('uuid', '!=', $employee->uuid)
                        ->get();  
    return view('cuti.updatecuti', compact('cuti', 'employees', 'd_cuti','reference'));
}

public function update(Request $request, $id)
{
    
    $request->validate([
        'jenis_cuti' => 'required|string',
        'keterangan' => 'required|string',
        'jumlah' => 'required|integer',
        'tanggal' => 'required|date',
        'karyawan_pengganti' => 'required|string',
        // 'tanggal_cuti' => 'required|array', 
        // 'tanggal_cuti.*' => 'required|date',
    ]);

    // Update data cuti
    $cuti = Cuti::findOrFail($id);
    $cuti->jenis_cuti = $request->jenis_cuti;
    $cuti->keterangan = $request->keterangan;
    $cuti->jumlah = $request->jumlah;
    $cuti->tanggal = $request->tanggal;
    $cuti->karyawan_pengganti = $request->karyawan_pengganti;
    $cuti->save();
    d_cuti::where('id_cuti', $id)->delete();

    foreach ($request->tanggal_cuti as $i=>$tanggal_cuti) {
        if($request->tanggal_cuti[$i] !=null){
            d_cuti::create([
                'id_cuti' => $cuti->id,
                'tanggal_cuti' => $tanggal_cuti,
            ]);
        }
    }
    return redirect('/cuti')->with('success', 'Data cuti berhasil diperbarui!');
}


        

}
