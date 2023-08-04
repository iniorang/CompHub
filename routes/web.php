<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\KompetisiController;
use App\Http\Controllers\OrgController;
use App\Http\Controllers\timController;
use App\Http\Controllers\TransaksiController;
use App\Http\Controllers\UserController;
use App\Models\Transaksi;

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


Route::get('/', [HomeController::class, 'index'])->name('beranda');
Route::get('/komp', [HomeController::class, 'allkomp'])->name('showallcomp');
Route::get('/komp/detail/{id}', [KompetisiController::class, 'detail'])->name('detailk');
Route::get('/tim', [HomeController::class, 'alltim'])->name('showalltim');
Route::get('/tim/detail/{id}', [timController::class, 'detail'])->name('detailt');
Auth::routes();

Route::middleware(['auth', 'user-access:user'])->group(function () {
    // Route::get('/profile',[UserController::class,''])->nama('profile');
    Route::match(['get', 'post'], '/joinKomp/{id}', [KompetisiController::class, 'ikutKomp'])->name('daftarsendiri');
    Route::get('/profile/{id}', [UserController::class, 'editprofile'])->name('profile');
    Route::put('/profile/update/{id}', [UserController::class, 'updateProfil'])->name('profile.update');
    Route::get('/profile/confirm/matikan', [UserController::class, 'deactivationForm'])->name('konfirmasi.matikan');
    Route::put('/profile/matikan',[UserController::class, 'deactivate'])->name('matikanakun');
    Route::get('/kompetisi/ikut/{id}', [KompetisiController::class, 'lihatIkut'])->name('profile.ikut');
    Route::get('/aturTim', [timController::class, 'timDash'])->name('manajemenTim');
    Route::get('/timcreation', [timController::class, 'showBuat'])->name('show.timCreation.user');
    Route::post('/timbuat', [timController::class, 'buatTim'])->name('create.tim.user');
    Route::post('/tim/{timId}', [TimController::class, 'ikutTim'])->name('ikuttim');
    Route::post('/tim/kick/{userId}', [timController::class, 'kick'])->name('kick');
    Route::post('/tim/disaband/{timId}', [timController::class, 'bubarkan'])->name('disband');
    Route::post('/tim/{timId}/keluar', [TimController::class, 'keluarTim'])->name('resign');
    Route::get('/tim/members/{id}', [timController::class, 'listAnggota'])->name('dashboardTim');
    Route::get('/tim/edit/{id}', [timController::class, 'editTim'])->name('user.update.tim');
    Route::put('/tim/update/tim/{id}', [timController::class, 'updateTim'])->name('view.user.update');

    //Expermential
    Route::post('/tim/minta-bergabung/{timId}', [TimController::class, 'mintaBergabung'])->name('minta-bergabung');
    Route::post('/tim/terima/{requestId}', [TimController::class, 'terimaPermintaan'])->name('terima-permintaan');
    Route::post('/tim/tolak/{requestId}', [TimController::class, 'tolakPermintaan'])->name('tolak-permintaan');
});

Route::middleware(['auth', 'user-access:admin'])->group(function () {
    Route::get('/admin', [KompetisiController::class, 'index'])->name('index');
    Route::get('/admin/create/Comp', [KompetisiController::class, 'create'])->name('kompetisi.create');
    Route::post('/admin/insert/Comp', [KompetisiController::class, 'store'])->name('kompetisi.store');
    Route::get('/admin/destroyComp/{id}', [KompetisiController::class, 'destroy'])->name('kompetisi.destroy');
    Route::get('/admin/detail/{id}', [KompetisiController::class, 'show'])->name('kompetisi.detail');
    Route::get('/admin/edit/comp/{id}', [KompetisiController::class, 'edit'])->name('kompetisi.edit');
    Route::put('/admin/update/comp/{id}', [KompetisiController::class, 'update'])->name('kompetisi.update');
    Route::get('/admin/cetak', [KompetisiController::class, 'printPDF'])->name('kompetisi.pdf');

    Route::get('/admin/create/user', [UserController::class, 'create'])->name('user.create');
    Route::post('/admin/insert/user', [UserController::class, 'store'])->name('user.store');
    Route::delete('/admin/destroyUser/{id}', [UserController::class, 'destroy'])->name('user.destroy');
    Route::get('/admin/edit/user/{id}', [UserController::class, 'edit'])->name('user.edit');
    Route::put('/admin/update/user/{id}', [UserController::class, 'update'])->name('user.update');
    Route::get('/admin/disabled/list', [UserController::class, 'listDisabledUsers'])->name('listdisabled');
    Route::put('/admin/users/{id}/disable', [UserController::class, 'disableUser'])->name('disable.user');
    Route::post('/admin/user/reactivate/{id}', [UserController::class, 'reactivateUser'])->name('user.reactivate');
    //  Route::delete('/admin/user/destroy/{id}', [UserController::class, 'destroyUser'])->name('user.destroy');


    Route::get('/admin/create/org', [OrgController::class, 'create'])->name('org.create');
    Route::post('/admin/insert/org', [OrgController::class, 'store'])->name('org.store');
    Route::delete('/admin/destroyOrg/{id}', [OrgController::class, 'destroy'])->name('org.destroy');
    Route::get('/admin/edit/org/{id}', [OrgController::class, 'edit'])->name('org.edit');
    Route::put('/admin/update/org/{id}', [OrgController::class, 'update'])->name('org.update');

    Route::get('/admin/create/tim', [timController::class, 'create'])->name('tim.create');
    Route::post('/admin/insert/tim', [timController::class, 'store'])->name('tim.store');
    Route::delete('/admin/destroyTim/{id}', [timController::class, 'destroy'])->name('tim.destroy');
    Route::get('/admin/detail/tim/{id}', [timController::class, 'show'])->name('tim.detail');
    Route::get('/admin/edit/tim/{id}', [timController::class, 'edit'])->name('tim.edit');
    Route::put('/admin/update/tim/{id}', [timController::class, 'update'])->name('tim.update');

    Route::get('/transactions/{id}/verify', [TransaksiController::class, 'verify'])->name('transactions.verify');
Route::get('/transactions/{id}/cancel', [TransaksiController::class, 'cancel'])->name('transactions.cancel');
});

Route::match(['get', 'post'], '/logout', [LoginController::class, 'logout'])->name('logout');
