<?php

use App\Http\Controllers\cutiController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\jadwalkerjaController;
use App\Http\Controllers\shiftController;
use App\Http\Controllers\masterController;
use App\Http\Controllers\menuController;
use Illuminate\Support\Facades\Session;
use App\Http\Controllers\UserProfileController;
use Illuminate\Support\Facades\Route;
use Stevebauman\Location\Facades\Location;
use Stevebauman\Location\Request;
use Torann\GeoIP\Facades\GeoIP;

Route::get('/', function () {
    return view('welcome');
});
Route::get('/session', function () {
    $data=Session::all();
    return $data;
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
    Route::get('/pilihjamkerja/{uuid}',[jadwalkerjaController::class,'pilihjamkerja']);
    Route::post('/getjamkerja',[jadwalkerjaController::class,'getjamkerja']);
    Route::post('/jadwalkerja/proses/input',[jadwalkerjaController::class,'input']);
    Route::post('/jadwalkerja/proses/update',[jadwalkerjacontroller::class,'update']);
    
    Route::get('/cuti',[cutiController::class,'index']);
    Route::get('/ajukancuti',[cutiController::class,'ajukancuti']);
    Route::post('/ajukancuti/proses/input',[cutiController::class,'input']);
    Route::post('/cuti/proses/update',[cutiController::class,'update']);
    Route::get('/formupdatee/{uuid_karyawan}',[cutiController::class,'formupdatee']);


    // Route::get('/form', [cutiController::class, 'create']);
    // Route::get('/getEmployeesByUnit/{unit_id}', [cutiController::class,'getEmployeesByUnit']);
    


    route::get('/logout-akun', function(){

        Session::flush(); // removes all session data

        return redirect('/');
    });

    Route::prefix('master')->group(function(){
        Route::get('menu', [menuController::class, 'index']);
        Route::get('{data}', [masterController::class,'index']);
        Route::get('data/{section}', [masterController::class,'data']);
        Route::get('{form}/{section}/{code?}', [masterController::class,'form']);
        Route::post('process/{section}', [masterController::class,'post']);
        Route::post('check/item', [masterController::class,'check_item']);
    });
});
// Route::get('test', function(){
//     return User::latest()->first();

//     Route::get('/profile2',[UserProfileController::class,'index'])->name('profile2.index');

// });

require __DIR__.'/auth.php';
