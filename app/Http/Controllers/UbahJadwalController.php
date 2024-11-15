<?php

namespace App\Http\Controllers;

use App\Models\Approve;
use App\Models\Employee;
use App\Models\shift;
use App\Models\ubahjadwal;
use App\Models\Unit;
use App\Models\workscheadules;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class UbahJadwalController extends Controller
{
    public function index()
{
    $uuid = Auth::user()->uuid;
    $ubahjadwal = DB::select("SELECT pemohon.name AS pemohon_name, pengganti.name AS pengganti_name, units.name AS unit_name, sa.name AS shift_name, sp.name AS shift_names, ubahjadwal.* 
    FROM ubahjadwal
    LEFT JOIN employees AS pemohon ON pemohon.uuid = ubahjadwal.uuid_pemohon
    LEFT JOIN employees AS pengganti ON pengganti.uuid = ubahjadwal.uuid_pengganti
    LEFT JOIN shifts AS sa ON sa.id = ubahjadwal.shift_awal  
    LEFT JOIN shifts AS sp ON sp.id = ubahjadwal.shift_pengganti  
    LEFT JOIN units ON pemohon.id_unit = units.id
    WHERE ubahjadwal.uuid_pemohon = ?", [$uuid]);
   
    return view('ubahjadwal.index', compact('uuid', 'ubahjadwal'));
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
        return (new UbahJadwalController)->getunit($value->id_head_unit, $array);
    }



}
public function tukarshift()
{
    // Ambil data yang sedang login
    $uuid = Auth::user()->uuid;
    $employeess = Employee::where('uuid', $uuid)->first();
    
    // Ambil karyawan pengganti berdasarkan id_unit
    $karyawan_pengganti = Employee::with(['workschedules.shift'])
        ->where('id_unit', $employeess->id_unit) // Mengambil data karyawan dalam satu unit
        ->where('uuid', '!=', $employeess->uuid)
        ->get();
    
    // Ambil shift
    $shift = Shift::all();
    $tahun = date('Y');
    $bulan = date('m');
    
    // Ambil jadwal kerja untuk karyawan saat ini
    $workSchedules = workscheadules::with('shift')
        ->select('tanggal', 'shift_id')
        ->where('uuid_employees', $uuid)
        ->whereMonth('tanggal', $bulan)
        ->whereYear('tanggal', $tahun)
        ->get();
    
    // Ambil jadwal pengganti berdasarkan bulan dan tahun
    $pengganti = workscheadules::with('shift')
        ->select('uuid_employees', 'tanggal', 'shift_id')
        ->whereMonth('tanggal', $bulan)
        ->whereYear('tanggal', $tahun)
        ->get();
    
    // Ambil data karyawan
    $karyawan = DB::table('employees as e')
        ->join('units as u', 'e.id_unit', '=', 'u.id')
        ->select('e.id AS employee_id', 'e.uuid', 'u.id AS unit_id', 'u.name AS unit_name', 'u.kepala_unit', 'u.id_head_unit')
        ->where('e.uuid', $uuid)
        ->first();
    
    
    
    // Ambil unit jika karyawan ditemukan
    if ($karyawan) {
        $units = collect((new ubahjadwalcontroller)->getunit($karyawan->unit_id))->where('id', '!=', 1);
    }
    
    // Return ke view dengan semua data yang diperlukan
    return view('ubahjadwal.tukarshift', [
        'units' => $units, 
        'employees' => $karyawan_pengganti,
        'employeess' => $employeess,
        'karyawan_pengganti' => $karyawan_pengganti,
        'workSchedules' => $workSchedules,
        'bulan' => $bulan,
        'tahun' => $tahun,
        'shift' => $shift,
        'karyawan' => $karyawan,
        'pengganti' => $pengganti,
    ]);
}



public function store(Request $request)
{
    
    $request->validate([
        "uuid_pengganti" => "required",
        "tanggal_perubahan" => "required",
        "shift_awal" => "required",
        "shift_pengganti" => "required",
        "alasan" => "required",
    ]);
    $uuid = Auth::user()->uuid;
    $employee = DB::table('employees')
        ->where('uuid', $uuid)
        ->first();

    if ($employee) {
    
        $ubahjadwal = ubahjadwal::create([
            'uuid_pemohon' => $uuid,
            'uuid_pengganti' => $request->input('uuid_pengganti'),
            'tanggal_perubahan' => $request->input('tanggal_perubahan'),
            'shift_awal' => $request->input('shift_awal'), 
            'shift_pengganti' => $request->input('shift_pengganti'),
            'keterangan' => $request->input('alasan'), 
            'status' => $request->input('status') ?? 0,
        ]);

        $ubahjadwal = ubahjadwal::latest()->first();
        for ($i=0; $i < count($request->persetujuan); $i++) {
    
            Approve::create([
                'id_permohonan' => $ubahjadwal->id,
                'jenis_permohonan' => 2,
                'uuid_atasan' => $request->persetujuan[$i],
            ]);
        }
    
    }

    return redirect()->route('ubahjadwal.index', ['uuid' => $uuid])->with('success', 'Tukar shift berhasil diajukan.');
}


public function getform($id)
{
  
    $uuid = Auth::user()->uuid;
    $ubahjadwal = ubahjadwal::find($id);
    // dd($ubahjadwal);
    $shifts = Shift::find($ubahjadwal->shift_awal);
    $reference = DB::table('references')->get();
    $employee = Employee::where('uuid', '=', $uuid)->first();

    
    $ubahjadwal->tanggal_perubahan = Carbon::parse($ubahjadwal->tanggal_perubahan)->format('Y-m-d');

    
    $karyawan_pengganti = Employee::with(['workschedules.shift'])
        ->where('id_unit', $employee->id_unit)
        ->where('uuid', '!=', $employee->uuid)
        ->get();

    
    $shift = Shift::all();
    $tahun = date('Y');
    $bulan = date('m');
    $workschedules = workscheadules::with('shift')
        ->select('tanggal', 'shift_id')
        ->where('uuid_employees', $uuid)
        ->whereMonth('tanggal', $bulan)
        ->whereYear('tanggal', $tahun)
        ->get();

    // Return view dengan data yang telah dipersiapkan
    return view('ubahjadwal.updateform', compact(
        'ubahjadwal', 'employee', 'karyawan_pengganti', 'shift', 'workschedules', 'shifts', 'reference'
    ));
}

public function update(Request $request, $id)
{
    // Validasi input dari form
    $request->validate([
        'uuid_pemohon' => 'required',
        'uuid_pengganti' => 'required',
        'tanggal_perubahan' => 'required',
        'shift_awal' => 'required',
        'shift_pengganti' => 'required',
        'keterangan' => 'required',
    ]);

    // Cari data ubahjadwal berdasarkan id
    $ubahjadwal = ubahjadwal::find($id);

    // Update data ubahjadwal dengan input dari form
    $ubahjadwal->uuid_pemohon = $request->uuid_pemohon;
    $ubahjadwal->uuid_pengganti = $request->uuid_pengganti;
    $ubahjadwal->keterangan = $request->keterangan;
    $ubahjadwal->tanggal_perubahan = $request->tanggal_perubahan;
    $ubahjadwal->shift_awal = $request->shift_awal;
    $ubahjadwal->shift_pengganti = $request->shift_pengganti;
    $ubahjadwal->save();

    // Redirect ke halaman index dengan pesan sukses
    return redirect()->route('ubahjadwal.index')
        ->with('success', 'Data  berhasil diperbarui!');
}



public function hapus($ubahjadwal){
    $ubahjadwal = ubahjadwal::find($ubahjadwal);
    // dd($ubahjadwal);
      if($ubahjadwal){
        Approve::where('id_permohonan', $ubahjadwal->id)->delete();
        $ubahjadwal->delete();
        return redirect()->route('ubahjadwal.index', ['uuid' => $ubahjadwal->uuid_pemohon])

        ->with('success','Pengajuan berhasil di Cancel');
    }
}
}
