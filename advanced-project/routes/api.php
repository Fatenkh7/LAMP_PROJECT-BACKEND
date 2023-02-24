<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\fixed_incomescontroller;
use App\Http\Controllers\CategoryController;

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

Route::post('/fixedincomes',[fixed_incomescontroller::class, 'addfixedincomes']);
Route::get('/fixedincomes', [fixed_incomescontroller::class,'index']);
Route::get('/fixedincomes/{id}', [fixed_incomescontroller::class,'getfixedincomes']);
Route::Put('/fixedincomes/{id}', [fixed_incomescontroller::class, 'editfixedincomes']);
Route::Delete('/fixedincomes/{id}', [fixed_incomescontroller::class, 'deletefixedincomes']);

Route::post('/category',[CategoryController::class, 'addcategory']);
Route::get('/category', [CategoryController::class,'index']);
Route::get('/category/{id}', [CategoryController::class,'getcategory']);
Route::Put('/category/{id}', [CategoryController::class, 'editcategory']);
Route::Delete('/category/{id}', [CategoryController::class, 'deletecategory']);