<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\FixedIncomeController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\RecurringIncomeController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\ProfitGoalController;
use App\Http\Controllers\CurrencyController;
use App\Http\Controllers\FixedExpenseController;
use App\Http\Controllers\RecurringExpenseController;

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

//fixed incomes
// Route::Post('/fixedincomes', [FixedIncomeController::class, 'addfixedincomes']);
// Route::Get('/fixedincomes', [FixedIncomeController::class, 'getAll']);
// Route::Get('/fixedincomes/{id}', [FixedIncomeController::class, 'getById']);
// Route::Put('/fixedincomes/{id}', [FixedIncomeController::class, 'editfixedincomes']);
// Route::Delete('/fixedincomes/{id}', [FixedIncomeController::class, 'deletefixedincomes']);

//Categories
Route::Post('/category', [CategoryController::class, 'addcategory']);
Route::Get('/category', [CategoryController::class, 'getAll']);
Route::Get('/category/name/{name}', [CategoryController::class, 'getByCategory']);
Route::Get('/category/id/{id}', [CategoryController::class, 'getById']);
Route::Put('/category/id/{id}', [CategoryController::class, 'editById']);
Route::Put('/category/name/{name}', [CategoryController::class, 'editByName']);
Route::Delete('/category/id/{id}', [CategoryController::class, 'deleteCategoryById']);
Route::Delete('/category/name/{name}', [CategoryController::class, 'deleteCategoryByName']);

//fixed expenses
// Route::Post('/fixedexpenses', [FixedExpenseController::class, 'addfixedexpenses']);
// Route::Get('/fixedexpenses', [FixedExpenseController::class, 'getallFixedexpenses']);
// Route::Get('/fixedexpenses/{id}', [FixedExpenseController::class, 'getByIDFixedexpenses']);
// Route::Put('/fixedexpenses/{id}', [FixedExpenseController::class, 'editFixedexpenses']);
// Route::Delete('/fixedexpenses/{id}', [FixedExpenseController::class, 'deleteFixedexpenses']);

// // Recurring Income routes
// Route::Post('/recurringincome', [RecurringIncomeController::class, 'addRecurringIncome']);
// Route::Get('/recurringincome/{id}', [RecurringIncomeController::class, 'getRecurringIncomeById']);
// Route::Get('/recurringincome', [RecurringIncomeController::class, 'getAllRecurringIncomes']);
// Route::Put('/recurringincome/{id}', [RecurringIncomeController::class, 'editRecurringIncome']);
// Route::Delete('/recurringincome/{id}', [RecurringIncomeController::class, 'deleteRecurringIncome']);

//report routes
Route::Get('/report', [ReportController::class, 'getAll']);
Route::Get('/report/{id}', [ReportController::class, 'getById']);
Route::Get('/report/type/{type}', [ReportController::class, 'getByType']);
Route::Post('/report', [ReportController::class, 'addReport']);
Route::Put('/report/{id}', [ReportController::class, 'editReport']);
Route::Delete('/report/{id}', [ReportController::class, 'deleteById']);
Route::Delete('/report/type/{type}', [ReportController::class, 'deleteByType']);

//profit goals routes
Route::Get('/profit', [ProfitGoalController::class, 'getAll']);
Route::Get('/profit/{id}', [ProfitGoalController::class, 'getById']);
Route::Get('/profit/title/{title}', [ProfitGoalController::class, 'getByTitle']);
Route::Post('/profit', [ProfitGoalController::class, 'addProfitGoal']);
Route::Put('/profit/id/{id}', [ProfitGoalController::class, 'editprofitById']);
Route::Put('/profit/title/{title}', [ProfitGoalController::class, 'editprofitByTitle']);
Route::Delete('/profit/{id}', [ProfitGoalController::class, 'deleteById']);
Route::Delete('/profit/title/{title}', [ProfitGoalController::class, 'deleteByTitle']);


//currencies
Route::Post('/currency', [CurrencyController::class, 'addCurrency']);
Route::Get('/currency', [CurrencyController::class, 'getAll']);
Route::Get('/currency/{id}', [CurrencyController::class, 'getCurrencyById']);
Route::Put('/currency/{id}', [CurrencyController::class, 'editCurrencyById']);
Route::Delete('/currency/{id}', [CurrencyController::class, 'deleteCurrency']);

// recurringexpenses
// Route::Post('/recurringexpenses', [RecurringExpenseController::class, 'addRecurringexpenses']);
// Route::Get('/recurringexpenses', [RecurringExpenseController::class, 'getallRecurringexpenses']);
// Route::Get('/recurringexpenses/{id}', [RecurringExpenseController::class, 'getByIDRecurringexpenses']);
// Route::Put('/recurringexpenses/{id}', [RecurringExpenseController::class, 'editRecurringexpenses']);
// Route::Delete('/recurringexpenses/{id}', [RecurringExpenseController::class, 'deleteRecurringexpenses']);
