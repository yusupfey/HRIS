<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\masterController;
use App\Http\Controllers\menuController;
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


// Route::get('/employees', [EmployeeController::class, 'index'])->name('employees.index');
// Route::get('/employees/create', [EmployeeController::class, 'create'])->name('employees.create');
// Route::post('/employees', [EmployeeController::class, 'store'])->name('employees.store');
// Route::get('/employees/{id}/edit', [EmployeeController::class, 'edit'])->name('employees.edit');
// Route::post('/employees/{id}', [EmployeeController::class, 'update'])->name('employees.update');

Route::middleware(['auth'])->group(function () {
    Route::get('/employees', [EmployeeController::class, 'index'])->name('employees.index');
    Route::get('/employees/create', [EmployeeController::class, 'create'])->name('employees.create');
    Route::post('/employees', [EmployeeController::class, 'store'])->name('employees.store');
    Route::get('/employees/{id}/edit', [EmployeeController::class, 'edit'])->name('employees.edit');
    Route::post('/employees/{id}', [EmployeeController::class, 'update'])->name('employees.update');
    Route::post('/employees/{id}/delete', [EmployeeController::class, 'destroy'])->name('employees.destroy');

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
