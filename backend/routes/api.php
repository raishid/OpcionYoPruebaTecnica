<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Employee\GetAvalaibleEmployee;
use App\Http\Controllers\Employee\GetEmployeeAvalaibleIntervalTime;


Route::get('/avaliable-employee', GetEmployeeAvalaibleIntervalTime::class)->name('avaliable-employee');
