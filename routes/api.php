<?php

use App\Http\Controllers\newemployeesController;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');


//api create employeees
Route::get('newemployees',[newemployeesController::class,'index'])->name('newemployees.index');
Route::post('create/employees',[newemployeesController::class,'create'])->withoutMiddleware([VerifyCsrfToken::class]);

//api user
Route::post('create/user');