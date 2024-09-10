<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use App\Models\Employee;
use App\Models\User;
use App\Models\Izin;
use App\Models\Approve;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;


class IzinController extends Controller
{

    public function index ()
    {
        $izinData = Izin::join('employees', 'izin.uuid_karyawan', '=', 'employees.uuid') // Asumsi kolom uuid_karyawan ada di tabel izin
        ->select('izin.*', 'employees.name')
        ->get();

    return view('izin.index', compact('izinData'));
    }





    public function newform(Request $request)
    {
        // Dapatkan UUID dari user yang sedang login
        $uuid = Auth::user()->uuid;

        // Ambil data karyawan berdasarkan UUID dan join dengan tabel units
        $employee = DB::table('employees as e')
            ->join('units as u', 'e.id_unit', '=', 'u.id')
            ->select('e.id AS employee_id', 'e.uuid', 'e.alamat', 'e.no_telp', 'u.id AS unit_id', 'u.name AS unit_name', 'u.kepala_unit', 'u.id_head_unit')
            ->where('e.uuid', $uuid)
            ->first();


        if ($employee) {
            // Ambil unit dengan ID lebih kecil dari unit_id milik employee
            $units = DB::table('units as u')
            ->join('employees as e', 'e.uuid', '=', 'u.kepala_unit')
            ->select('e.name as nama_karyawan', 'u.*')
            ->where('u.id', '<=', $employee->id_head_unit + 1)
            ->where('u.id', '!=', 1)
            ->get();
            return view('izin.form', ['employee' => $employee, 'units' => $units]);



            //ubah jadi Ambil unit dengan ID lebih kecil dari id_head_unit milik units
        } else {
            // Jika data tidak ditemukan, kembalikan view dengan pesan error atau redirect
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
            'alamat' => 'nullable|string',
            'notelp' => 'nullable|string',
        ]);

        // Dapatkan UUID dari user yang sedang login
        $uuid = Auth::user()->uuid;

        // Ambil data karyawan berdasarkan UUID
        $employee = DB::table(' employees')
            ->where('uuid', $uuid)
            ->first();

        if ($employee) {

            // Simpan data izin ke dalam tabel izin
            Izin::create([
                'uuid_karyawan' => $uuid,
                'start_time' => $request->input('starttime'),
                'end_time' => $request->input('endtime'),
                'alasan' => $request->input('alasan'),
                'alamat' => $request->input('alamat'),
                'notelpon' => $request->input('notelp'),
            ]);

            $izin = Izin::latest()->first();


            // // Simpan data ke tabel approve untuk setiap unit yang dipilih
            // foreach ($request->input('units') as $unit_id) {
            //     $unit = DB::table('hris2_db.units')->where('id', $unit_id)->first();

            //     DB::table('approve')->insert([
            //         'id_permohonan' => $employee->id,
            //         'jenis_permohonan' => 2,
            //         'uuid_atasan' => $unit->kepala_unit,
            //     ]);
            // }

            for ($i=0; $i < count($request->persetujuan); $i++) {

                Approve::create([
                    'id_permohonan' => $izin->id,
                    'jenis_permohonan' => 2,
                    'uuid_atasan' => $request->persetujuan[$i],
                ]);
             }

            return redirect()->route('izin.index')->with('success', 'Izin berhasil dibuat.');
        } else {
            return redirect()->back()->with('error', 'Data karyawan tidak ditemukan.');
        }
    }



}







