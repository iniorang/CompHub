<?php

use App\Http\Controllers\Auth\LoginController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\KompetisiController;
use App\Http\Controllers\OrgController;
use App\Http\Controllers\timController;
use App\Http\Controllers\UserController;


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


Route::get('/', function () {
    return view('home');
})->name('beranda');
Auth::routes();

Route::middleware(['auth','user-access:user'])->group(function(){
    // Route::get('/profile',[UserController::class,''])->nama('profile');
});

Route::middleware(['auth','user-access:admin'])->group(function(){
    Route::get('/admin', [KompetisiController::class, 'index'])->name('index');
    Route::get('/admin/create/Comp',[KompetisiController::class,'create'])->name('kompetisi.create');
    Route::post('/admin/insert/Comp',[KompetisiController::class,'store'])->name('kompetisi.store');
    Route::get('/admin/destroyComp/{id}',[KompetisiController::class,'destroy'])->name('kompetisi.destroy');
    Route::get('/admin/detail',[KompetisiController::class,'show'])->name('kompetisi.detail');
    Route::get('/admin/edit/comp/{id}',[KompetisiController::class,'edit'])->name('kompetisi.edit');
    Route::put('/admin/update/comp/{id}',[KompetisiController::class,'update'])->name('kompetisi.update');
    Route::get('/admin/cetak',[KompetisiController::class,'printPDF'])->name('kompetisi.pdf');

    Route::get('/admin/create/user',[UserController::class,'create'])->name('user.create');
    Route::post('/admin/insert/user',[UserController::class,'store'])->name('user.store');
    Route::get('/admin/destroyUser/{id}',[UserController::class,'destroy'])->name('user.destroy');
    Route::get('/admin/edit/user/{id}',[UserController::class,'edit'])->name('user.edit');
    Route::put('/admin/update/user/{id}',[UserController::class,'update'])->name('user.update');

    Route::get('/admin/create/org',[OrgController::class,'create'])->name('org.create');
    Route::post('/admin/insert/org',[OrgController::class,'store'])->name('org.store');
    Route::get('/admin/destroyOrg/{id}',[OrgController::class,'destroy'])->name('org.destroy');
    Route::get('/admin/edit/org/{id}',[OrgController::class,'edit'])->name('org.edit');
    Route::put('/admin/update/org/{id}',[OrgController::class,'update'])->name('org.update');

    Route::get('/admin/create/tim',[timController::class,'create'])->name('tim.create');
    Route::post('/admin/insert/tim',[timController::class,'store'])->name('tim.store');
    Route::get('/admin/destroyTim/{id}',[timController::class,'destroy'])->name('tim.destroy');
    Route::get('/admin/edit/tim/{id}',[timController::class,'edit'])->name('tim.edit');
    Route::put('/admin/update/tim/{id}',[timController::class,'update'])->name('tim.update');
});

Route::match(['get','post'],'/logout', [LoginController::class, 'logout'])->name('logout');


