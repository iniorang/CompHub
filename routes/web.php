<?php

use App\Http\Controllers\Auth\LoginController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\KompetisiController;


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

Route::middleware(['auth','user-access:admin'])->group(function(){
    Route::get('/admin', [KompetisiController::class, 'index'])->name('index');
    Route::get('/admin/create/Comp',[KompetisiController::class,'create'])->name('kompetisi.create');
    Route::post('/admin/insert/Comp',[KompetisiController::class,'store'])->name('kompetisi.store');
    Route::get('/admin/destroyComp/{id}',[KompetisiController::class,'destroy'])->name('kompetisi.destroy');
    Route::get('/admin/detail',[KompetisiController::class,'show'])->name('kompetisi.detail');
    Route::get('/admin/edit/{id}',[KompetisiController::class,'edit'])->name('kompetisi.edit');
    Route::put('/admin/update/{id}',[KompetisiController::class,'update'])->name('kompetisi.update');
    Route::get('/admin/cetak',[KompetisiController::class,'printPDF'])->name('kompetisi.pdf');
});

Route::match(['get','post'],'/logout', [LoginController::class, 'logout'])->name('logout');


