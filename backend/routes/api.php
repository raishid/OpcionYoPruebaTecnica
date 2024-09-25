<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Employee\GetAvalaibleEmployee;
use App\Http\Controllers\Employee\StoreEmployeeController;
use App\Http\Controllers\Employee\UpdateEmployeeController;
use App\Http\Controllers\Employee\GetEmployeeAvalaibleIntervalTime;


Route::get('/employe-avalaible-horaries', GetEmployeeAvalaibleIntervalTime::class)->name('avaliable.horaries');
Route::get('/employee-avalaible', GetAvalaibleEmployee::class)->name('employee.avalaible');
Route::post('/employee', StoreEmployeeController::class)->name('employee.store');
Route::put('/employee/{employee}', UpdateEmployeeController::class)->name('employee.update');
