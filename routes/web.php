<?php

use App\Http\Controllers\CompaniesController;
use App\Http\Controllers\EmployeesController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/dashboard', [App\Http\Controllers\HomeController::class, 'index'])->name(name: 'home');
Route::resource('companies', CompaniesController::class)->middleware('auth');
Route::resource('employees',EmployeesController::class)->middleware('auth');