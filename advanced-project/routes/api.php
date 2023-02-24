<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\RecurringIncomeController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\FixedExpensesController;
use App\Http\Controllers\Recurringexpensescontroller;
use App\Http\Controllers\ProfitGoalsController;
use App\Http\Controllers\CurrenciesController;

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

//recurring expenses
Route::Post('/recurringexpenses', [Recurringexpensescontroller::class, 'addRecurringexpenses']);
Route::Get('/recurringexpenses', [Recurringexpensescontroller::class, 'getallRecurringexpenses']);
Route::Get('/recurringexpenses/{id}', [Recurringexpensescontroller::class, 'getByIDRecurringexpenses']);
Route::Put('/recurringexpenses/{id}', [Recurringexpensescontroller::class, 'editRecurringexpenses']);
Route::Delete('/recurringexpenses/{id}', [Recurringexpensescontroller::class, 'deleteRecurringexpenses']);

//currencies
Route::Post('/currency', [CurrenciesController::class, 'addCurrency']);
Route::Get('/currency', [CurrenciesController::class, 'getAll']);
Route::Get('/currency/{id}', [CurrenciesController::class, 'getCurrencyById']);
Route::Put('/currency/{id}', [CurrenciesController::class, 'editCurrencyById']);
Route::Delete('/currency/{id}', [CurrenciesController::class, 'deleteCurrency']);
