<?php

use App\Http\Controllers\AnggotaController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\JemaatController;
use App\Http\Controllers\KkController;
use App\Http\Controllers\SessionController;
use App\Http\Controllers\EksporController;
use GuzzleHttp\Cookie\SessionCookieJar;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return redirect()->route('sesi');
})->name('root');


Route::prefix('dashboard')->group(function() {
    Route::get('', [DashboardController::class, 'index'])->name('dashboard');
});


// Route::controller(KkController::class)->prefix('kk')->group(function(){
//     Route::get('', 'index')->name('kk');
// });

// Route::controller(AnggotaController::class)->prefix('anggota')->group(function(){
//     Route::get('', 'index' )->name('anggota') ;
// });

// Route::controller(JemaatController::class)->prefix('anggota')->group(function(){
//     Route::get('', 'index' )->name('anggota') ;
// });

Route::get('kk', function () {
    return view('kk.index');
})->name('kk')->middleware('isLogin');


Route::resource('kkdata', KkController::class)->middleware('isLogin');
Route::resource('anggotadata', AnggotaController::class)->middleware('isLogin');
Route::get('kkdata/{id}', 'KkController@show')->name('detail')->middleware('isLogin');
Route::post('/kkdata/{kkId}/anggotadata', [AnggotaController::class, 'store'])->name('anggota.store')->middleware('isLogin');
Route::put('/kkdata/{kkId}/anggotadata/{id}', [AnggotaController::class, 'update'])->name('anggota.update')->middleware('isLogin');
Route::get('/kkdata/{kkId}/anggotadata', [AnggotaController::class, 'index'])->name('anggotadata.index')->middleware('isLogin');
Route::resource('/kkdata/{kkId}/anggotadata', AnggotaController::class)->middleware('isLogin');

Route::get('/jemaat', [JemaatController::class, 'index'])->name('jemaat')->middleware('isLogin');
Route::get('/anggotadata', [JemaatController::class, 'anggotaData'])->name('anggotadata')->middleware('isLogin');


// Rute-rute Sesi
Route::get('/sesi', [SessionController::class, 'index'])->name('sesi')->middleware('isTamu');
Route::post('/sesi/login', [SessionController::class, 'login'])->name('login')->middleware('isTamu');
Route::post('/sesi/logout', [SessionController::class, 'logout'])->name('logout')->middleware('isLogin');
// Route::get('/sesi/register', [SessionController::class, 'register'])->name('register')->middleware('isTamu');
// Route::post('/sesi/create', [SessionController::class, 'create'])->name('create')->middleware('isTamu');

Route::get('/ekspor-data', [EksporController::class, 'exportData'])->name('ekspor.data');

