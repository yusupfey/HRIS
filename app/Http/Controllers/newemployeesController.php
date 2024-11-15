<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class newemployeesController extends Controller
{
    public function index(){
        return 'test';
    }    
    public function create(request $request){
        // return 'tes';
        // $valid =$request->validate([
        //     'name' => 'required|string|max:255',
        //     'DOB' => 'required|date',
        //     'tempat_lahir' => 'required|string|max:100',
        //     'no_telp' => 'required',
        //     'alamat' => 'required|string',
        //     'jenis_kelamin' => 'required|integer',
        //     'photo' => 'nullable|image' 
        // ]);
        // if ($valid->fails()){
        //     return response()->json([
        //         'status'=>false,
        //         'message'=>'proses validasi gagal',
        //         'data'=> $request->errors()
        //     ],400);
        // }
        if ($request->hasFile('photo')) {
            $file = $request->file('photo');
            $filename = time() . '_' . $file->getClientOriginalName();
            $filePath = $file->storeAs('uploads/photos', $filename, 'public');
        } else {
            $filePath = null;
        }
        $uuid = Str::uuid();
        // Simpan data ke database, termasuk path foto
        Employee::create([
            'uuid' => $uuid,
            'name' => $request->name,
            'DOB' => $request->DOB,
            'no_telp' => $request->no_telp,
            'tempat_lahir' => $request->tempat_lahir,
            'alamat' => $request->alamat,
            'jenis_kelamin' => $request->jenis_kelamin,
            'id_unit' => $request->id_unit,
            'photo' => $filePath 
        ]);

        User::create([
            'uuid' => $uuid,
            'name' => $request->name,
            'username' => $request->username,
            'email' => $request->email,
            'password' => Hash::make('123456'),
        ]);
        return response()->json([
            'status'=>true,
            'message'=>'berhasil memasukan data',
        ],200);

    }
    
}
