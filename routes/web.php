<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EmployeeController;

Route::get('/', function () {
    return view('welcome');
});

Route::resource('employees', EmployeeController::class);
Route::get('/employees', [EmployeeController::class, 'index']);
Route::post('/employees/store', [EmployeeController::class, 'store']);
Route::get('/employees/{id}/edit', [EmployeeController::class, 'edit'])->name('employees.edit');
Route::put('/employees/update/{id}', [EmployeeController::class, 'update']);
Route::delete('/employees/delete/{id}', [EmployeeController::class, 'destroy']);

Route::get('/get-designations/{department_id}', [EmployeeController::class, 'getDesignations']);