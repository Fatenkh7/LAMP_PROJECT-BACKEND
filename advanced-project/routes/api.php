<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\RecurringIncomeController;

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

// Recurring Income routes
Route::Post('/recurringincome', [RecurringIncomeController::class, 'addRecurringIncome']);
Route::Get('/recurringincome/{id}', [RecurringIncomeController::class, 'getRecurringIncomeById']);
Route::Get('/recurringincome', [RecurringIncomeController::class, 'getAllRecurringIncomes']);
Route::Put('/recurringincome/{id}', [RecurringIncomeController::class, 'editRecurringIncome']);
Route::Delete('/recurringincome/{id}', [RecurringIncomeController::class, 'deleteRecurringIncome']);
