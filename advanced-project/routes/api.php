<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\report_controller;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
//admin routes
Route::Get('/admin/{id}', [AdminController::class, 'getAdmin']);
Route::Post('/admin', [AdminController::class, 'addAdmin']);
Route::Put('/admin/{id}', [AdminController::class, 'editAdmin']);
Route::Delete('/admin/{id}', [AdminController::class, 'deleteAdmin']);


//report routes
Route::Get('/report', [report_controller::class, 'getAll']);
Route::Get('/report/{id}', [report_controller::class, 'getById']);
Route::Get('/report/{type}', [report_controller::class, 'getByType']);
Route::Post('/report', [report_controller::class, 'addReport']);
Route::Put('/report/{id}', [report_controller::class, 'editReport']);
Route::Delete('/report/{id}', [report_controller::class, 'deleteById']);
Route::Delete('/report/{type}', [report_controller::class, 'deleteByType']);
