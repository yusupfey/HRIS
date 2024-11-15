<?php

namespace App\Http\Controllers;

use App\Models\Approve;
use App\Models\Sakit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class SakitController extends Controller
{
    public function index()
    {
        $user = Auth::user()->uuid;
    
        $sakit = DB::select("SELECT e1.name AS karyawan_name, units.name AS unit, sakit.* 
            FROM sakit
            LEFT JOIN employees AS e1 ON e1.uuid = sakit.uuid_karyawan
            LEFT JOIN units ON e1.id_unit = units.id
            WHERE sakit.uuid_karyawan = ?", [$user]);
            // dd($sakit);
    
        return view('sakit.index', compact('sakit', 'user'));
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

    public function getsakit(){
        $uuid = Auth::user()->uuid;
        $sakit = Sakit::all();

        $karyawan = DB::table('employees as e')
        ->join('units as u', 'e.id_unit', '=', 'u.id')
        ->select('e.id AS employee_id', 'e.uuid', 'u.id AS unit_id', 'u.name AS unit_name', 'u.kepala_unit', 'u.id_head_unit')
        ->where('e.uuid', $uuid)
        ->first();
    // Ambil unit jika karyawan ditemukan
    if ($karyawan) {
        // $units_name = DB::table('units as u')
        // ->select( 'u.*')
        // ->where('u.id', '<', value: $karyawan->id_head_unit + 1)
        // ->where('u.id', '!=', 1)
        // ->get();
        // $units = DB::table('units as u')
        // ->join('d_units as du', 'du.id_unit', '=', 'u.id')
        // ->join('employees as e', 'e.uuid', '=', 'du.uuid_pj')
        // ->select('e.name as nama_karyawan', 'u.*', 'du.*')
        // ->where('u.id', '<=', value: 3)//id ini id unit manager keperawatan
        // ->where('u.id', '!=', 1)
        // ->get();
        $units = collect((new SakitController)->getunit($karyawan->unit_id))->where('id', '!=', 1);
            // dd($units);
            // dd($units_name);
    }
        return view('sakit.ajukansakit',compact('uuid','karyawan','units'));
    }
    public function store(Request $request)
    {
        // Validasi input
        $validatedData = $request->validate([
            'tanggal' => 'required|date',
            'path' => 'required|file',
            'keterangan' => 'required|string',
            'days' => 'required|integer',
            'persetujuan' => 'required|array',
        ]);
    
        // Proses upload file
        if ($request->hasFile('path')) {
            $file = $request->file('path');
            $filePath = $file->store('uploads/sakit', 'public'); 
        }
    
        // Ambil UUID pengguna yang sedang login
        $uuid = Auth::user()->uuid;
    
        // Buat instance baru dari model Sakit
        $sakit = new Sakit();
        $sakit->uuid_karyawan = $uuid; // Tambahkan kuuid karyawan di sini
        $sakit->tanggal = $validatedData['tanggal'];
        $sakit->path = $filePath;
        $sakit->keterangan = $validatedData['keterangan'];
        $sakit->days = $validatedData['days'];
        $sakit->status = $validatedData['status'] ?? 0;

        $sakit->save();
    
        // Ambil data user yang sedang login
        $employee = DB::table('employees')->where('uuid', $uuid)->first();
    
        if ($employee) {
            // Simpan persetujuan
            foreach ($request->persetujuan as $persetujuan) {
                Approve::create([
                    'id_permohonan' => $sakit->id,
                    'jenis_permohonan' => 4,
                    'uuid_atasan' => $persetujuan,
                ]);
            }
            return redirect()->route('sakit.index')->with('success', 'Berhasil Ajukan Sakit');
        }
        
        return redirect()->back()->withErrors('Karyawan tidak ditemukan.');
    }
    

public function edit($id){
    $sakit = Sakit::find($id);
    // dd($sakit);
    $units = DB::table('units')->get();
    // dd($units);
    return view('sakit.updatesakit',compact('sakit','units'));
}
public function update(Request $request, $id){
        $validasidata = $request->validate([
            'tanggal'=>'Required',
            // 'path' => 'required|file',
            'keterangan' => 'required|string',
            'days' => 'required|integer',
        ]);
        $sakit = Sakit::find($id);
// dd($request->hasFile('path'));
        if ($request->hasFile('path')) {
            $file = $request->file('path');
            // if($sakit->path){
                //     Storage::disk('public')->delete($sakit->path);
                // }
            // $path = \Str::uuid(36).'.'.$file->getClientOriginalExtension();
            //     $file->move('storage/uploads/sakit',$path);
                
            // $filePath = 'storage/uploads/sakit/'.$path;
            $filePath = $file->store('uploads/sakit', options: 'public'); 
            // dd());
        }else{
            // dd('tes');
            $filePath  = $request->path_upload;
        }
            $sakit = Sakit::find($id);
            $sakit->tanggal = $validasidata['tanggal'];
            $sakit->keterangan = $validasidata['keterangan'];
            $sakit->days = $validasidata['days'];
            $sakit->path = $filePath;
            // dd($sakit);
            $sakit->save();
        
        return redirect('/sakit')->with('success','Berhasil Update Data');

}
public function hapus($sakit){

    $sakit = sakit::find($sakit);
      if($sakit){
        Approve::where('id_permohonan', $sakit->id)->delete();
        if ($sakit->path) {
            Storage::disk('public')->delete($sakit->path);
        }
        $sakit->delete();
        return redirect()->route('sakit.index')

        ->with('success','Pengajuan berhasil di Cancel');
    }
}



}
