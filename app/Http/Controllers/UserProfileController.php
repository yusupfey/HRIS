<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use App\Models\Employee;

class UserProfileController extends Controller
{
    public function edit()
    {
        $user = auth()->user();
        $employee = $user->employee;

        return view('profile.edit', compact('user', 'employee'));
    }

    public function update(Request $request)
    {
        $user = auth()->user();

        $request->validate([
            'name' => 'required|string|max:255',
            'DOB' => 'required|date',
            'tempat_lahir' => 'required|string|max:255',
            'alamat' => 'required|string|max:255',
            'jenis_kelamin' => 'required|integer|in:0,1',
        ]);

        $data = $request->only('name', 'DOB', 'tempat_lahir', 'alamat', 'jenis_kelamin');

        $user->employee()->updateOrCreate(['uuid' => $user->id], $data);

        return redirect()->route('profile.edit')->with('success', 'Profile updated successfully.');
    }
}
