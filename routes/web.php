<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\EmployeeController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Session;
use App\Http\Controllers\UserProfileController;
use App\Models\User;

Route::get('/', function () {
    return view('welcome');
});
Route::get('/session', function () {
    $data=Session::all();
    return $data;
    });

Route::get('/dashboard', function () {
    return view('dashboard2');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});


Route::middleware(['auth'])->group(function () {
    Route::get('/employees', [EmployeeController::class, 'index'])->name('employees.index');
    Route::get('/employees/{uuid}/create', [EmployeeController::class, 'create'])->name('employees.create');

    Route::post('/employees', [EmployeeController::class, 'store'])->name('employees.store');
    Route::get('/employees/{uuid}/edit', [EmployeeController::class, 'edit'])->name('employees.edit');
    Route::post('/employees/{uuid}', [EmployeeController::class, 'update'])->name('employees.update');
    Route::get('/employees/{uuid}', [EmployeeController::class, 'show'])->name('employees.show');
    Route::post('/employees/{id}/delete', [EmployeeController::class, 'destroy'])->name('employees.destroy');

    Route::get('/profile2', [UserProfileController::class, 'index'])->name('profile2.index');

    route::get('/logout-akun', function(){

        Session::flush(); // removes all session data

        return redirect('/');
    });

});
Route::get('test', function(){
    return User::latest()->first();

});

require __DIR__.'/auth.php';
