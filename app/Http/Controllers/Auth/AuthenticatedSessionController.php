<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use App\Models\User;


class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    public function store(LoginRequest $request): RedirectResponse
{
    try {
       
        $request->authenticate();
        $request->session()->regenerate();
        $data = User::where('email', $request->email)->first();
        $request->session()->put('uuid', $data->uuid);
        return redirect()->intended(route('dashboard2', absolute: false));
    } catch (\Exception $e) {
       
        return redirect()->back()->with('error', 'Email atau password salah!');
    }
}

    // public function store(LoginRequest $request): RedirectResponse
    // {
    //     $request->authenticate();

    //     $request->session()->regenerate();
    //     $data=User::where('email', $request->email)->first();
    //     $request->session()->put('uuid', $data->uuid);
    //     return redirect()->intended(route('dashboard2', absolute: false));
    // }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
