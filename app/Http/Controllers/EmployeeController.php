<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Employee;
use App\Models\User;

class EmployeeController extends Controller
{
    public function index()
    {
        $employees = Employee::all();
        return view('employees.index', compact('employees'));
    }

    public function create($uuid)
{
    // Ambil data user berdasarkan uuid jika diperlukan
    $user = User::where('uuid', $uuid)->firstOrFail();

    // Lanjutkan dengan logika pembuatan karyawan
    return view('employees.create', compact('user'));
}


    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'DOB' => 'required|date',
            'tempat_lahir' => 'required|string|max:100',
            'alamat' => 'required|string',
            'jenis_kelamin' => 'required|integer',
        ]);

        Employee::create($request->all());

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
        $request->validate([

            'name' => 'required|string|max:255',
            'DOB' => 'required|date',
            'tempat_lahir' => 'required|string|max:100',
            'alamat' => 'required|string',
            'jenis_kelamin' => 'required|integer',
        ]);

        $employee = Employee::findOrFail($id);
        $employee->update($request->all());

        return redirect()->route('employees.index')->with('success', 'Employee updated successfully.');
    }
    public function destroy($id, Request $request)
    {
        $employee = Employee::findOrFail($id);
        $employee->delete();

        return redirect()->route('employees.index')->with('success', 'Employee deleted successfully.');
    }
}
