<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\RecurringIncomeController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\ProfitGoalsController;
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

//report routes
Route::Get('/report', [ReportController::class, 'getAll']);
Route::Get('/report/{id}', [ReportController::class, 'getById']);
Route::Get('/report/type/{type}', [ReportController::class, 'getByType']);
Route::Post('/report', [ReportController::class, 'addReport']);
Route::Put('/report/{id}', [ReportController::class, 'editReport']);
Route::Delete('/report/{id}', [ReportController::class, 'deleteById']);
Route::Delete('/report/type/{type}', [ReportController::class, 'deleteByType']);

//profit goals routes
Route::Get('/profit', [ProfitGoalsController::class, 'getAll']);
Route::Get('/profit/{id}', [ProfitGoalsController::class, 'getById']);
Route::Get('/profit/title/{title}', [ProfitGoalsController::class, 'getByTitle']);
Route::Post('/profit', [ProfitGoalsController::class, 'addprofitGoals']);
Route::Put('/profit/id/{id}', [ProfitGoalsController::class, 'editprofitById']);
Route::Put('/profit/title/{title}', [ProfitGoalsController::class, 'editprofitByTitle']);
Route::Delete('/profit/{id}', [ProfitGoalsController::class, 'deleteById']);
Route::Delete('/profit/title/{title}', [ProfitGoalsController::class, 'deleteByTitle']);