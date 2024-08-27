<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use App\Models\Employee;
use App\Models\User;
use App\Models\Izin;


class IzinController extends Controller
{
    public function index()
    {

        return view('izin.index');
    }

    public function newform(Request $request)
    {
        $validatedData = $request->validate([
            'uuid_karyawan' => 'required|size:36',
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i',
            'alasan' => 'required|string',
            'alamat' => 'required|string',
            'notelpon' => 'required|size:255',
            'status' => 'required|integer',
            'inactive_date' => 'nullable|date_format:Y-m-d H:i:s',
        ]);

        Izin::create($request->all());
        return view('izin.form');
    }





}







