<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Employee;

class EmployeeController extends Controller
{
    public function index()
    {
        $employees = Employee::all();
        return view('employees.index', compact('employees'));
    }

    public function create()
    {
        return view('employees.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'uuid' => 'required|string|max:16|unique:employees',
            'name' => 'required|string|max:255',
            'DOB' => 'required|date',
            'tempat_lahir' => 'required|string|max:100',
            'alamat' => 'required|string',
            'jenis_kelamin' => 'required|integer',
        ]);

        Employee::create($request->all());

        return redirect()->route('employees.index')->with('success', 'Employee created successfully.');
    }

    public function edit($id)
    {
        $employee = Employee::findOrFail($id);
        return view('employees.edit', compact('employee'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'uuid' => 'required|string|max:16|unique:employees,uuid,' . $id,
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
