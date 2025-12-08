<?php

use App\Http\Controllers\Admin\BrandController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\ColorController;
use App\Http\Controllers\Admin\SubCategoryController;
use App\Http\Controllers\Admin\UserController;
use App\Models\Subcategory;
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
Route::get('/search_category/{name?}',[CategoryController::class,'search_cat'])->name('category.search');
Route::post('/category/store',[CategoryController::class,'store'])->name('category.store');
Route::post('/category/{id}/update',[CategoryController::class,'update'])->name('category.update');
Route::delete('/category/{id}/destroy',[CategoryController::class,'destroy'])->name('category.destroy');


//sub-category routes is hare
Route::get('/admin-all_subcagegory',[SubCategoryController::class,'allCategory'])->name('all_subcategory');
Route::get('/search_subcategory/{name?}',[SubCategoryController::class,'search_cat'])->name('subcategory.search');
Route::post('/subcategory/store',[SubCategoryController::class,'store'])->name('subcategory.store');
Route::post('/subcategory/{id}/update',[SubCategoryController::class,'update'])->name('subcategory.update');
Route::delete('/subcategory/{id}/destroy',[SubCategoryController::class,'destroy'])->name('subcategory.destroy');

//brand routes is hare
Route::get('/brand',[BrandController::class,'allbrands'])->name('brand');
Route::get('/brand_search/{name?}',[BrandController::class,'search'])->name('brand.search');
Route::post('/brand/store',[BrandController::class,'store'])->name('brand.store');
Route::post('/brand/{id}/update',[BrandController::class,'update'])->name('brand.update');
Route::delete('/brand/{id}/destroy',[BrandController::class,'destroy'])->name('brand.destroy');

//Colour routes is hare
Route::get('/colour',[ColorController::class,'allColor'])->name('color');
Route::get('/colour_search/{name?}',[ColorController::class,'search'])->name('color.search');
Route::post('/colour/store',[ColorController::class,'store'])->name('color.store');
Route::post('/colour/{id}/update',[ColorController::class,'update'])->name('color.update');
Route::delete('/colour/{id}/destroy',[ColorController::class,'destroy'])->name('color.destroy');

