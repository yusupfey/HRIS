<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Employee;
use App\Models\User;
use Illuminate\Support\Str;

class EmployeeController extends Controller
{
    public function index()
    {
        $employees = Employee::all();
        // dd($employees);
        return view('employees.index', compact('employees'));
    }

    public function create($uuid)
    {
        // Ambil data user berdasarkan uuid jika diperlukan
        $user = User::where('uuid', $uuid)->firstOrFail();
        $employees = Employee::all();


        // Lanjutkan dengan logika pembuatan karyawan
        return view('/employees/create', compact('user','employees'));
    }


    public function store(Request $request)
{
    
    $request->validate([
        'name' => 'required|string|max:255',
        'DOB' => 'required|date',
        'tempat_lahir' => 'required|string|max:100',
        'no_telp' => 'required',
        'alamat' => 'required|string',
        'jenis_kelamin' => 'required|integer',
        'photo' => 'nullable|image' 
    ]);

   
    if ($request->hasFile('photo')) {
        $file = $request->file('photo');
        $filename = time() . '_' . $file->getClientOriginalName();
        $filePath = $file->storeAs('uploads/photos', $filename, 'public');
    } else {
        $filePath = null;
    }

    // Simpan data ke database, termasuk path foto
    Employee::create([
        'uuid' => Str::uuid(),
        'name' => $request->name,
        'DOB' => $request->DOB,
        'no_telp' => $request->no_telp,

        'tempat_lahir' => $request->tempat_lahir,
        'alamat' => $request->alamat,
        'jenis_kelamin' => $request->jenis_kelamin,
        'photo' => $filePath 
    ]);

    // Redirect ke halaman dashboard atau halaman lainnya
    return view('dashboard2');
}


    public function edit($uuid)
    {

        $employee = Employee::where('uuid', $uuid)->firstOrFail();
        return view('employees.edit', [
            'employee' => $employee,
        ]);
    }

    public function update(Request $request, $id)
    {
        // Validasi input dari form
        $request->validate([
            'name' => 'required|string|max:255',
            'DOB' => 'required|date',
            'tempat_lahir' => 'required|string|max:100',
            'alamat' => 'required|string',
            'jenis_kelamin' => 'required|integer',
            'photo' => 'nullable|image|max:2048'
        ]);
    
        $employee = Employee::findOrFail($id);
        if ($request->hasFile('photo')) {
            $photoPath = $request->file('photo')->store('photos', 'public');
            
            $employee->photo = $photoPath;
        }
        $employee->update($request->except(['photo'])); 
    
        
        return redirect()->route('employees.index')->with('success', 'Employee updated successfully.');
    }
    
    public function destroy($id, Request $request)
    {
        $employee = Employee::findOrFail($id);
        $employee->delete();

        return redirect()->route('employees.index')->with('success', 'Employee deleted successfully.');
    }
}
