<?php

use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::get('/allusers',[UserController::class,'allUsers']);
Route::post('/store-user',[UserController::class,'store']);
Route::post('/store-user/{id}/update',[UserController::class,'update']);
Route::post('/user/{id}/delete',[UserController::class,'deleteUser'])->name('deleteuser');


//category routes is hare
Route::get('/admin-all_cagegory',[CategoryController::class,'allCategory'])->name('all_category');
Route::post('/category/store',[CategoryController::class,'store'])->name('category.store');
Route::post('/category/{id}/update',[CategoryController::class,'update'])->name('category.update');
Route::delete('/category/{id}/destroy',[CategoryController::class,'destroy'])->name('category.destroy');
