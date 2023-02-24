<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\FixedExpensesController;
use App\Http\Controllers\Recurringexpensescontroller;

use App\Http\Controllers\RecurringIncomeController;
use App\Http\Controllers\ReportController;
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


// Admin routes
Route::Get('/admin/{id}', [AdminController::class, 'getAdminById']);
Route::Get('/admin', [AdminController::class, 'getAllAdmins']);
Route::Post('/admin', [AdminController::class, 'addAdmin']);
Route::Put('/admin/{id}', [AdminController::class, 'editAdmin']);
Route::Delete('/admin/{id}', [AdminController::class, 'deleteAdmin']);

//fixed expenses
Route::Post('/fixedexpenses', [FixedExpensesController::class, 'addfixedexpenses']);
Route::Get('/fixedexpenses', [FixedExpensesController::class, 'getallFixedexpenses']);
Route::Get('/fixedexpenses/{id}', [FixedExpensesController::class, 'getByIDFixedexpenses']);
Route::Put('/fixedexpenses/{id}', [FixedExpensesController::class, 'editFixedexpenses']);
Route::Delete('/fixedexpenses/{id}',[FixedExpensesController::class , 'deleteFixedexpenses']);

//recurring expenses
Route::Post('/recurringexpenses', [Recurringexpensescontroller::class, 'addRecurringexpenses']);
Route::Get('/recurringexpenses', [Recurringexpensescontroller::class, 'getallRecurringexpenses']);
Route::Get('/recurringexpenses/{id}', [Recurringexpensescontroller::class, 'getByIDRecurringexpenses']);
Route::Put('/recurringexpenses/{id}', [Recurringexpensescontroller::class, 'editRecurringexpenses']);
Route::Delete('/recurringexpenses/{id}', [Recurringexpensescontroller::class, 'deleteRecurringexpenses']);
