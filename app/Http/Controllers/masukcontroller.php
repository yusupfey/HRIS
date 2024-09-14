<?php

namespace App\Http\Controllers;

use App\Models\absen;
use App\Models\Employee;
use App\Models\workscheadules;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;

class masukcontroller extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('absenmasuk.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */


    // public function masuk(Request $request)
    // {
    //     $user = Auth::user();
    //     $employees = Employee::where('uuid', $user->id)->first();
    //     $schedule = workscheadules::where('uuid_karyawan', $employees->id)->first();

    //     // Simpan data absensi
    //     $absen = new absen();
    //     $absen->uuid_karyawan = $employees->uuid;
    //     $absen->type = 'masuk'; // Menandakan absen masuk
    //     $absen->in_date = Carbon::now(); // Waktu saat ini
    //     $absen->schd_id = $schedule->id; // ID jadwal
    //     $absen->latlong = $request->input('latlong') ?? null; // Tidak ada data lokasi
    //     $absen->remark = 'Hadir'; // Keterangan kehadiran
    //     $absen->save();
    //     dd($absen);

    //     return redirect()->back()->with('success', 'Absensi berhasil disimpan');
    // }


    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
