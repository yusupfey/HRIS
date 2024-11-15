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
        $cuti = DB::select("SELECT e1.name,dr.val_name as cuti, units.name as unit, cuti.*, e2.name as pengganti_name, dr.val_name FROM cuti
            LEFT JOIN employees e1 on e1.uuid=cuti.uuid_karyawan
            LEFT JOIN units on e1.id_unit=units.id
            LEFT JOIN d_references dr on dr.val=cuti.jenis_cuti and reference_id=1
            LEFT JOIN employees e2 on e2.uuid=cuti.karyawan_pengganti 
            where cuti.uuid_karyawan='$user'");
        // dd($cuti);
        // $cuti = cuti::join('employees', 'cuti.uuid_karyawan', '=', 'employees.uuid') // Asumsi kolom uuid_karyawan ada di tabel izin
        // ->select('employees.name','cuti.*')
        // ->get();
        // dd($cuti);

    return view('cuti.index', compact('cuti','user'));
}
public function getunit($getUnit, $arr = []){
    $array = $arr;
    $units = DB::table('units as u')
    ->join('employees as e', 'e.uuid', '=', 'u.kepala_unit')
    ->select('e.name as nama_karyawan', 'u.*')
    ->where('u.id', '=', $getUnit)
    ->get();
    if(count($units) > 0){
        // dd('ada data');
        foreach ($units as $key => $value) {
            array_push($array, $value);
            $return = true;
        }
    }else{
       $return = false;
    }
    if(!$return){
        return $array;
    }else{
        return (new cutiController)->getunit($value->id_head_unit, $array);
    }



}
public function getcuti()
{
    $uuid = Auth::user()->uuid;  
    $employees = Employee::where('uuid', '=', Session::get('uuid'))->first(); 

    $karyawan_pengganti = Employee::where('id_unit', '=', $employees->id_unit)
        ->where('uuid', '!=', $employees->uuid)
        ->get(); 

    $reference = DB::table('d_references')
        ->where('reference_id', 1)
        ->get();

    $employees = DB::table('employees as e')
        ->join('units as u', 'e.id_unit', '=', 'u.id')
        ->select('e.id AS employee_id', 'e.uuid', 'u.id AS unit_id', 'u.name AS unit_name', 'u.kepala_unit', 'u.id_head_unit')
        ->where('e.uuid', $uuid)
        ->first();

    if ($employees) {
        $units = collect((new cutiController)->getunit($employees->unit_id))->where('id', '!=', 1);
        // dd($units);
        return view('cuti.ajukancuti', [
            'employees' => $karyawan_pengganti,
            'units' => $units,
            'reference' => $reference
        ]);
    } else {
        return redirect()->back()->with('error', 'Data karyawan tidak ditemukan.');
    }
}

public function store(Request $request){
    $request->validate([
        "jenis_cuti"=>"Required",
        "jumlah"=>"Required",
        // "karyawan_pengganti"=>"nullable",
        "keterangan"=>"Required",

        ]);
        $request['approved_pengganti'] = null;
    //  if ($request->has('karyawan_pengganti')) {
    //         $request['karyawan_pengganti'] = $request->karyawan_pengganti;
    //     }
        $request['status'] = 0;
        $request['tanggal'] = date('Y-m-d');
        $request['tanggal_cuti'] = $request->tanggal_cuti;
        $request['karyawan_pengganti'] = $request->karyawan_pengganti;


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
                        // $cuti->status = 1;
                        // $cuti->save();

                    
                     return redirect()->route('cuti.index')->with('success', 'Cuti berhasil diajukan.');
                    }else {
                        return redirect()->back()->with('error', 'Data karyawan tidak ditemukan.');
                        
        }  
    }
public function formupdatee($id)
{
   
    $cuti = Cuti::find($id);
    $cuti->tanggal = Carbon::parse($cuti->tanggal)->format('Y-m-d');

    $d_cuti = d_cuti::where('id_cuti', $id)->get();
    $reference=DB::table('d_references')->where('reference_id',1)->get();
    // dd($reference);

    $employee = Employee::where('uuid', '=', Session::get('uuid'))->first();
//karyawan pengganti
    $employees = Employee::where('id_unit', '=', $employee->id_unit)
                        ->where('uuid', '!=', $employee->uuid)
                        ->get();  
                        // dd($employees);
    return view('cuti.updatecuti', compact('cuti', 'employees', 'd_cuti','reference','employee'));
}

public function update(Request $request, $id)
{
    
    $request->validate([
        'jenis_cuti' => 'required',
        'keterangan' => 'required',
        'jumlah' => 'required|integer',
        'tanggal' => 'required|date',
        'karyawan_pengganti' => 'nullable',
        // 'tanggal_cuti' => 'required|array', 
        // 'tanggal_cuti.*' => 'required|date',
    ]);

    // Update data cuti
    $cuti = Cuti::find($id);
    $cuti->jenis_cuti = $request->jenis_cuti;
    $cuti->tanggal = $request->tanggal;
    $cuti->keterangan = $request->keterangan;
    $cuti->jumlah = $request->jumlah;
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
    return redirect()->route('cuti.index')->with('success', 'Data cuti berhasil diperbarui!');
}
public function hapus($cuti)
{
    // Temukan data cuti berdasarkan ID
    $cuti = Cuti::find($cuti);
    if ($cuti) {
        
        Approve::where('id_permohonan', $cuti->id)->delete();
        DB::table('d_cuti')->where('id_cuti', $cuti->id)->delete();

        $cuti->delete();

        return redirect('/cuti')
            ->with('success', 'Pengajuan berhasil di Cancel');
    }
    $cuti = Cuti::where('uuid_karyawan', '<', Carbon::now()->subDays(1))->get();
    foreach ($cuti as $post) {
        $post->delete();
    }
}




        

}
