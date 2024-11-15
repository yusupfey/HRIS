<?php

use Torann\GeoIP\Facades\GeoIP;
use Stevebauman\Location\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Session;
use App\Http\Controllers\IzinController;
use App\Http\Controllers\menuController;
use App\Http\Controllers\shiftController;
use App\Http\Controllers\masterController;
use Stevebauman\Location\Facades\Location;
use App\Http\Controllers\ApproveController;
use App\Http\Controllers\cutiController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\MyJadwalController;
use App\Http\Controllers\ReferenceController;
use App\Http\Controllers\jadwalkerjaController;
use App\Http\Controllers\masukcontroller;
use App\Http\Controllers\newemployeesController;
use App\Http\Controllers\SakitController;
use App\Http\Controllers\UbahJadwalController;
use App\Http\Controllers\UserProfileController;

Route::get('/', function () {
    return redirect()->route('login');
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





Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});


Route::middleware(['auth'])->group(function () {
    Route::get('dashboard2', [DashboardController::class, 'index'])->name('dashboard2');
    Route::post('/absen/store',[DashboardController::class,'absen']);


    // Route::post('/absen/masuk', [DashboardController::class, 'masuk'])->name('absen.masuk');

    // izin
    Route::get('/izin', [IzinController::class, 'index'])->name('izin.index');
Route::get('/ajukanizin', [IzinController::class, 'getizin'])->name('izin.form');
Route::post('/izin/store', [IzinController::class, 'store'])->name('izin.store');
Route::get('/updateizin/{id}',[IzinController::class,'getupdate']);
Route::post('/izin/proses/update/{id}', [IzinController::class, 'update'])->name('izin.update');
Route::get('/izin/delete/{id}', [IzinController::class, 'hapus'])->name('izin.destroy');




    Route::get('/myjadwal/{uuid}', [MyJadwalController::class, 'index'])->name('myjadwal.index');

    // cuti route

    Route::get('/cuti',[cutiController::class,'index'])->name('cuti.index');
    Route::get('/ajukancuti',[cutiController::class,'getcuti'])->name('cuti.ajukancuti');
    Route::post('/store', [cutiController::class, 'store'])->name('cuti.store');
    Route::post('/cuti/proses/update/{id}', [cutiController::class, 'update'])->name('cuti.update');
    Route::get('/formupdatee/{id}',[cutiController::class,'formupdatee']);
    Route::get('/cuti/delete/{id}', [cutiController::class, 'hapus'])->name('cuti.destroy');
    Route::get('/cuti/update-status/{id}', [cutiController::class, 'updateStatus'])->name('cuti.updateStatus');

    // Route::get('/approve/data/cuti',[cutiController::class,'formupdatee']);

    // employees
    Route::get('/employees', [EmployeeController::class, 'index'])->name('employees.index');
    Route::get('/employees/create/{uuid}', [EmployeeController::class, 'create'])->name('employees.create');

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

    Route::get('/ubahjadwal/{uuid}', [UbahJadwalController::class, 'index'])->name('ubahjadwal.index');
    Route::get('/tukarshift',[UbahJadwalController::class,'tukarshift']);
    Route::post('/tukarshift/store', [UbahJadwalController::class, 'store'])->name('ubahjadwal.store');
    Route::get('/updateform/{id}',[UbahJadwalController::class,'getform']);
    Route::post('/ubahjadwal/update/{id}', [UbahjadwalController::class, 'update'])->name('ubhjdwal.update');
    Route::get('/ubahjadwal/delete/{id}', [UbahJadwalController::class, 'hapus'])->name('ubahjadwal.destroy');

    // Route::get('/ubahjadwal/{uuid}', [UbahJadwalController::class, 'show'])->name('ubahjadwal.show');

    // Route::post('/approve/data/ubahjadwal', [UbahJadwalController::class, 'getUbahJadwalData']);

    //sakit//
    Route::get('sakit',[SakitController::class,'index'])->name('sakit.index');
    Route::get('ajukanSakit',[SakitController::class,'getsakit']);
    Route::post('formsakit/store',[SakitController::class,'store'])->name('sakit.store');
    Route::get('/update/{id}',[SakitController::class,'edit']);
    Route::post('/sakit/update/{id}', [SakitController::class, 'update'])->name('sakit.update');
    Route::get('/sakit/delete/{id}', [SakitController::class, 'hapus'])->name('sakit.destroy');







    




    //masuk kerja
     Route::get('/masukkerja',[masukcontroller::class,'index']);
     


    // Route::get('/form', [cutiController::class, 'create']);
    // Route::get('/getEmployeesByUnit/{unit_id}', [cutiController::class,'getEmployeesByUnit']);

    // reference
    Route::prefix('reference')->group(function(){
        Route::get('{id}', [ReferenceController::class,'index']);
    });
    Route::prefix('approve')->group(function(){
        Route::get('/', [ApproveController::class,'index']);
        Route::post('/data/{get}', [ApproveController::class,'data']);
        Route::post('/store/{answer}', [ApproveController::class,'store']);
    });

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
// Route::get('newemployees',[newemployeesController::class,'index'])->name('newemployees.index');
// Route::post('create/employees',[newemployeesController::class,'create'])->name('create.employees');





// Route::get('test', function(){
//     return User::latest()->first();

//     Route::get('/profile2',[UserProfileController::class,'index'])->name('profile2.index');

// });
require __DIR__.'/auth.php';
