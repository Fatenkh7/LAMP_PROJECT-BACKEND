<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\ProfitGoalController;
use App\Http\Controllers\CurrencyController;
use App\Http\Controllers\RecurringTransactionController;
use App\Http\Controllers\FixedTransactionController;
use App\Http\Controllers\FixedKeyController;
use App\Http\Controllers\BalanceController;
Use App\Http\Controllers\AuthController;


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

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//         return $request->user();
//     });
// Route::group([
//     'middleware' => 'api',
//     'prefix' => 'admin'
// ], function ($router) {
//     Route::Post('/login', [AuthController::class, 'login']);
//     Route::Post('/logout', [AuthController::class, 'logout']);   
    
// });


Route:: Post('/login', [AuthController::class, 'login']);
Route::Post('/register', [AuthController::class, 'register']);

Route::middleware(['authorize'])->group(function () {
    Route::Post('/logout', [AuthController::class, 'logout']);
    Route::Post('/refresh', [AuthController::class, 'refresh']);
    Route::Get('/user-profile', [AuthController::class, 'userProfile']); 
    
    // Admin routes
    Route::Get('/admin/{id}', [AdminController::class, 'getAdminById']);
    Route::Get('/admin', [AdminController::class, 'getAllAdmins']);
    Route::Post('/admin', [AdminController::class, 'addAdmin']);
    Route::Patch('/admin/{id}', [AdminController::class, 'editAdmin']);
    Route::Delete('/admin/{id}', [AdminController::class, 'deleteAdmin']);





    //profit goals routes
    Route::Get('/profit', [ProfitGoalController::class, 'getAll']);
    Route::Get('/profit/{id}', [ProfitGoalController::class, 'getById']);
    Route::Get('/profit/title/{title}', [ProfitGoalController::class, 'getByTitle']);
    Route::Post('/profit', [ProfitGoalController::class, 'addProfitGoal']);
    Route::Patch('/profit/id/{id}', [ProfitGoalController::class, 'editprofitById']);
    Route::Patch('/profit/title/{title}', [ProfitGoalController::class, 'editprofitByTitle']);
    Route::Delete('/profit/{id}', [ProfitGoalController::class, 'deleteById']);
    Route::Delete('/profit/title/{title}', [ProfitGoalController::class, 'deleteByTitle']);


    // Recurring Transaction
    Route::Post('/recurringTransaction', [RecurringTransactionController::class, 'addRecurringTransaction']);
    Route::Patch('/recurringTransaction/{id}', [RecurringTransactionController::class, 'editRecurringTransaction']);
    Route::Patch('/recurringTransaction', [RecurringTransactionController::class, 'editBy']);
    Route::Get('/recurringTransaction', [RecurringTransactionController::class, 'getAllRecurringTransactions']);
    Route::Get('/recurringTransaction/{id}', [RecurringTransactionController::class, 'getRecurringTransactionById']);
    Route::Get('/recurringTransaction', [RecurringTransactionController::class, 'getBy']);
    Route::Delete('/recurringTransaction/{id}', [RecurringTransactionController::class, 'deleteById']);
    Route::Delete('/recurringTransaction', [RecurringTransactionController::class, 'deleteBy']);



    //balance
    Route::Get('/balance', [BalanceController::class, 'balance']); 
    Route::Get('/balance/fixed', [BalanceController::class, 'calculateTheFixing']);
    Route::Get('/balance/recurring', [BalanceController::class, 'calculateTheRecurring']);

});

    //Categories
    Route::Post('/category', [CategoryController::class, 'addcategory']);
    Route::Get('/category', [CategoryController::class, 'getAll']);
    Route::Get('/category/name/{name}', [CategoryController::class, 'getByCategory']);
    Route::Get('/category/{id}', [CategoryController::class, 'getById']);
    Route::Patch('/category/id/{id}', [CategoryController::class, 'editById']);
    Route::Patch('/category/name/{name}', [CategoryController::class, 'editByName']);
    Route::Delete('/category/id/{id}', [CategoryController::class, 'deleteCategoryById']);
    Route::Delete('/category/name/{name}', [CategoryController::class, 'deleteCategoryByName']);
    //currencies
    Route::Post('/currency', [CurrencyController::class, 'addCurrency']);
    Route::Get('/currency', [CurrencyController::class, 'getAll']);
    Route::Get('/currency/{id}', [CurrencyController::class, 'getCurrencyById']);
    Route::Patch('/currency/{id}', [CurrencyController::class, 'editCurrencyById']);
    Route::Delete('/currency/{id}', [CurrencyController::class, 'deleteCurrency']);


       //fixed

       Route::Post('/fixedtransaction', [FixedTransactionController::class, 'addfixedTrans']);
       Route::Get('/fixedtransaction', [FixedTransactionController::class, 'getBy']);
       Route::Patch('/fixedtransaction', [FixedTransactionController::class, 'editBy']);
       Route::Get('/fixedtransaction/all', [FixedTransactionController::class, 'getAll']);
       Route::Get('/fixedtransaction/id/{id}', [FixedTransactionController::class, 'getById']);
       Route::Patch('/fixedtransaction/id/{id}', [FixedTransactionController::class, 'editFixedById']);
       Route::Delete('/fixedtransaction', [FixedTransactionController::class, 'deleteBy']);
       Route::Delete('/fixedtransaction/id/{id}', [FixedTransactionController::class, 'deleteById']);

           // Fixed key 

    Route::Post('/fixedkey', [FixedKeyController::class, 'addFixedKey']);
    Route::Get('/fixedkey', [FixedKeyController::class, 'getFixedkey']);
    Route::Get('/fixedkey/{id}', [FixedKeyController::class, 'getByIDFixedkey']);
    Route::Patch('/fixedkey/{id}', [FixedKeyController::class, 'editFixedkey']);
    Route::Delete('/fixedkey/{id}', [FixedKeyController::class, 'deleteFixedkey']);


        //report routes
        Route::Get('/report', [ReportController::class, 'getAll']);
        Route::Get('/report/{id}', [ReportController::class, 'getById']);
        Route::Get('/report/type/{type}', [ReportController::class, 'getByType']);
        Route::Post('/report', [ReportController::class, 'addReport']);
        Route::Patch('/report/{id}', [ReportController::class, 'editReport']);
        Route::Delete('/report/{id}', [ReportController::class, 'deleteById']);
        Route::Delete('/report/type/{type}', [ReportController::class, 'deleteByType']);
        
// Route::middleware(['authorize'])->group(function () {
//     // Patch your protected routes here
//     Route::Get('/admin', [AdminController::class, 'getAllAdmins']);

// });

// Route::middleware('auth:admin')->group(function () {
// });

// Route::get('/user', function (Request $request) {
//     return $request->user();
// });

