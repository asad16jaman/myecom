<?php

use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\BrandController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\ColorController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\SubCategoryController;
use App\Http\Controllers\Admin\UserController;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/


Route::get('admin/login',[AuthController::class,'index'])->name('login');
Route::post('admin/login',[AuthController::class,'authenticate'])->name('login');
Route::get('/logout',[AuthController::class,'adminLogout'])->name('logout');

Route::group(['prefix' => 'admin','middleware' => 'authAdmin'],function(){   

    Route::get('/',[DashboardController::class , 'index'])->name('dashboard');
    
});

Route::group(['prefix' => 'admin','middleware' => 'authAdmin'],function(){   

    Route::get('list',[DashboardController::class , 'ddd'])->name('list');
    Route::get('/user',[UserController::class,'create'])->name('admin.user');

    //category route
    Route::get('/categry',[CategoryController::class,'create'])->name('admin.category');

    //Sub Category
    Route::get('/sub-categry',[SubCategoryController::class,'create'])->name('admin.subcategory');

    //Sub Category
    Route::get('/brand',[BrandController::class,'create'])->name('admin.brand');

    //Sub Category
    Route::get('/color',[ColorController::class,'create'])->name('admin.color');


});


Route::get('/', function () {
    return view('welcome');
});



