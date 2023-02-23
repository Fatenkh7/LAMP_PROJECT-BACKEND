<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\FixedExpensesController;
use App\Http\Controllers\Recurringexpensescontroller;

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
Route::Get('/admin/{id}', [AdminController::class, 'getAdmin']);
Route::Post('/admin', [AdminController::class, 'addAdmin']);
Route::Put('/admin/{id}', [AdminController::class, 'editAdmin']);
Route::Delete('/admin/{id}', [AdminController::class, 'deleteAdmin']);


Route::Post('/fixedexpenses', [FixedExpensesController::class, 'addfixedexpenses']);
Route::Get('/fixedexpenses', [FixedExpensesController::class, 'getallFixedexpenses']);
Route::Put('/fixedexpenses/{id}', [FixedExpensesController::class, 'editFixedexpenses']);
Route::Delete('/fixedexpenses/{id}',[FixedExpensesController::class , 'deleteFixedexpenses']);

Route::Post('/recurringexpenses', [Recurringexpensescontroller::class, 'addRecurringexpenses']);
Route::get('/recurringexpenses', [Recurringexpensescontroller::class, 'getallRecurringexpenses']);
Route::Put('/recurringexpenses/{id}', [Recurringexpensescontroller::class, 'editRecurringexpenses']);
Route::Delete('/recurringexpenses/{id}', [Recurringexpensescontroller::class, 'deleteRecurringexpenses']);
