<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\jadwalkerjaController;
use App\Http\Controllers\shiftController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard2');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});


// Route::get('/employees', [EmployeeController::class, 'index'])->name('employees.index');
// Route::get('/employees/create', [EmployeeController::class, 'create'])->name('employees.create');
// Route::post('/employees', [EmployeeController::class, 'store'])->name('employees.store');
// Route::get('/employees/{id}/edit', [EmployeeController::class, 'edit'])->name('employees.edit');
// Route::post('/employees/{id}', [EmployeeController::class, 'update'])->name('employees.update');

Route::middleware(['auth'])->group(function () {
    // employees
    Route::get('/employees', [EmployeeController::class, 'index'])->name('employees.index');
    Route::get('/employees/create', [EmployeeController::class, 'create'])->name('employees.create');
    Route::post('/employees', [EmployeeController::class, 'store'])->name('employees.store');
    Route::get('/employees/{id}/edit', [EmployeeController::class, 'edit'])->name('employees.edit');
    Route::post('/employees/{id}', [EmployeeController::class, 'update'])->name('employees.update');
    Route::post('/employees/{id}/delete', [EmployeeController::class, 'destroy'])->name('employees.destroy');
    // shift
    Route::get('/shift',[shiftController::class,'index']);
    Route::get('/tambahshift',[shiftController::class,'tambahshift']);
    Route::get('/formupdate/{id}',[shiftController::class,'formupdate']);
    Route::post('/shift/proses/input',[shiftController::class,'input']);
    Route::get('/shift/delete/{id}', [ShiftController::class, 'hapus'])->name('shift.destroy');
    Route::post('/shift/proses/update',[shiftController::class,'update']);
    
    // work schedule //
    Route::get('/jadwalkerja',[jadwalkerjaController::class,'index']);
    Route::get('/pilihjamkerja',[jadwalkerjaController::class,'pilihjamkerja']);
    Route::post('/jamkerja/proses/input',[jadwalkerjaController::class,'input']);



});

require __DIR__.'/auth.php';
