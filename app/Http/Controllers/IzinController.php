<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use App\Models\Employee;
use App\Models\Izin;
use App\Models\Approve;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class IzinController extends Controller
{
    // Menampilkan semua izin
    public function index()
    {
        $user= Auth::user()->uuid;//ambil data yang login//
        $izin = DB::select("SELECT e1.name, units.name as unit, izin.* FROM izin
        LEFT JOIN employees e1 on e1.uuid=izin.uuid_karyawan
        LEFT JOIN units on e1.id_unit=units.id
        where izin.uuid_karyawan='$user'");
        // dd($izin);
        // $izin = Izin::where('uuid_karyawan', $user)->get();

        return view('izin.index', compact('izin','user'));
    }

    // Menampilkan form untuk membuat izin baru
    public function getizin()
    {
        // Dapatkan UUID dari user yang sedang login
        $uuid = Auth::user()->uuid;
    $reference=DB::table('d_references')->where('reference_id',7)->get();

// dd($reference);
        // Ambil data karyawan berdasarkan UUID dan join dengan tabel units
        $employee = DB::table('employees as e')
            ->join('units as u', 'e.id_unit', '=', 'u.id')
            ->select('e.id AS employee_id', 'e.uuid', 'e.alamat', 'e.no_telp', 'u.id AS unit_id', 'u.name AS unit_name', 'u.kepala_unit', 'u.id_head_unit')
            ->where('e.uuid', $uuid)
            ->first();
            // dd($employee);

        if ($employee) {
            // Ambil unit dengan ID lebih kecil dari id_head_unit milik employee
            $units = DB::table('units as u')
                ->join('employees as e', 'e.uuid', '=', 'u.kepala_unit')
                ->select('e.name as nama_karyawan', 'u.*')
                ->where('u.id', '<=', $employee->id_head_unit + 1)
                ->where('u.id', '!=', 1)
                // ->where('u.id',2)
                ->get();

                // dd($units);

            return view('izin.form', ['employee' => $employee, 'units' => $units,'reference'=>$reference]);
        } else {
            // Jika data tidak ditemukan, redirect dengan pesan error
            return redirect()->back()->with('error', 'Data karyawan tidak ditemukan.');
        }
    }
    public function store(Request $request)
    {
        // Validasi data yang diterima dari formulir
        $request->validate([
            'starttime' => 'required',
            'endtime' => 'required',
            'alasan' => 'required|string',
            'notelp' => 'nullable|string',
            'persetujuan' => 'required|array', 
        ]);

        // Dapatkan UUID dari user yang sedang login
        $uuid = Auth::user()->uuid;

        // Ambil data karyawan berdasarkan UUID
        $employee = Employee::where('uuid', $uuid)->first();

        if ($employee) {
            // Simpan data izin ke dalam tabel izin
            $izin = Izin::create([
                'uuid_karyawan' => $uuid,
                'start_time' => $request->input('starttime'),
                'end_time' => $request->input('endtime'),
                'alasan' => $request->input('alasan'),  
                'notelpon' => $request->input('notelp'),
                'status' => 0, // Status default
                'alamat' =>'',
            ]);

            // Simpan data ke tabel approve untuk setiap unit yang dipilih
            foreach ($request->persetujuan as $persetujuan) {
                Approve::create([
                    'id_permohonan' => $izin->id,
                    'jenis_permohonan' => 3,
                    'uuid_atasan' => $persetujuan,
                ]);
            }

            return redirect()->route('izin.index')->with('success', 'Izin berhasil dibuat.');
        } else {
            return redirect()->back()->with('error', 'Data karyawan tidak ditemukan.');
        }
    }
    public function getupdate($id)
{
   
    $izin = Izin::find($id);
    // dd($izin);
    // $reference=DB::table('references')->where('id',7)->get();
// dd($reference);
    $employee = Employee::where('uuid', '=', Session::get('uuid'))->first();
    // dd($employee);
   

    // $employees = Employee::where('id_unit', '=', $employee->id_unit)
    //                     ->where('uuid', '!=', $employee->uuid)
    //                     ->get();  
    return view('izin.updateizin', compact('izin', 'employee'));
}
public function update(Request $request, $id)
{
    
    $request->validate([
        // 'uuid_karyawan' => 'required|string',
        'start_time' => 'required|string',
        'end_time' => 'required|string',
        'alasan' => 'required|string',
        
    ]);

    // Update data cuti
    $izin = izin::findOrFail($id);
    // $izin->uuid_karyawan = $request->uuid_karyawan;
    $izin->start_time = $request->start_time;
    $izin->end_time = $request->end_time;
    $izin->alasan = $request->alasan;
    $izin->save();

    
    return redirect('/izin')->with('success', 'Data cuti berhasil diperbarui!');
}
public function hapus($izin){
    $izin = Izin::find($izin);
      if($izin){
        Approve::where('id_permohonan', $izin->id)->delete();
        $izin->delete();
        return redirect('/izin')
        ->with('success','Pengajuan berhasil di Cancel');
    }
}
}
