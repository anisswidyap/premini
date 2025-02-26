<?php

use App\Http\Controllers\ApiAdmin;
use App\Http\Controllers\ApiDosen;
use App\Http\Controllers\ApiDosenMatkul;
use App\Http\Controllers\ApiFakultas;
use App\Http\Controllers\ApiJurusan;
use App\Http\Controllers\ApiMahasiswa;
use App\Http\Controllers\ApiMahasiswaMatkul;
use App\Http\Controllers\ApiMatkul;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\LandingPageController;
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

Route::post('login', [AuthenticatedSessionController::class, 'store'])->name('login');
Route::middleware('auth:sanctum')->post('/logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');

Route::get('/landingpage', [LandingPageController::class, 'index']);

Route::apiResource('admin', ApiAdmin::class);
Route::apiResource('dosen', ApiDosen::class);
Route::apiResource('matkul', ApiMatkul::class);
Route::apiResource('fakultas', ApiFakultas::class);
Route::apiResource('jurusan', ApiJurusan::class);
Route::apiResource('mahasiswa', ApiMahasiswa::class);
Route::apiResource('mahasiswamatkul', ApiMahasiswaMatkul::class);
Route::apiResource('dosenmatkul', ApiDosenMatkul::class);



//anis
