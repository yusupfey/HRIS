<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\jadwalkerjaController;
use App\Http\Controllers\shiftController;
use App\Http\Controllers\masterController;
use App\Http\Controllers\menuController;
use App\Http\Controllers\UserProfileController;
use Illuminate\Support\Facades\Route;
use Stevebauman\Location\Facades\Location;
use Stevebauman\Location\Request;
use Torann\GeoIP\Facades\GeoIP;

Route::get('/', function () {
    return view('welcome');
});
Route::get('/getlocation', function(){
    // $position = Location::get('192.168.103.81');
    // $position = $request->getIp();
    // $position = GeoIP::getLocation();
    $position=$_SERVER['REMOTE_ADDR'];
    dd($position);
});
Route::get('/getlokasi', [ProfileController::class, 'testLokasi']);


Route::get('/dashboard', function () {
    return view('dashboard2');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});



Route::middleware(['auth'])->group(function () {
    // employees
    Route::get('/employees', [EmployeeController::class, 'index'])->name('employees.index');
    Route::get('/employees/{uuid}/create', [EmployeeController::class, 'create'])->name('employees.create');

    Route::post('/employees', [EmployeeController::class, 'store'])->name('employees.store');
    Route::get('/employees/{uuid}/edit', [EmployeeController::class, 'edit'])->name('employees.edit');
    Route::post('/employees/{uuid}', [EmployeeController::class, 'update'])->name('employees.update');
    Route::get('/employees/{uuid}', [EmployeeController::class, 'show'])->name('employees.show');
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
    Route::get('/jamkerja/delete/{name}',[jadwalkerjaController::class,'hapus'])->name('jadwalkerja.destroy');

    Route::get('/profile2',[UserProfileController::class,'index'])->name('profile2.index');

    Route::prefix('master')->group(function(){
        Route::get('menu', [menuController::class, 'index']);
        Route::get('{data}', [masterController::class,'index']);
        Route::get('data/{section}', [masterController::class,'data']);
        Route::get('{form}/{section}/{code?}', [masterController::class,'form']);
        Route::post('process/{section}', [masterController::class,'post']);
        Route::post('check/item', [masterController::class,'check_item']);
    });
});

require __DIR__.'/auth.php';
