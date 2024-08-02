<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\BiodataController;
use App\Http\Controllers\CastController;

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

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/register', [BiodataController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [BiodataController::class, 'processRegister'])->name('process_register');
Route::get('/welcome', [BiodataController::class, 'welcome'])->name('welcome');

Route::get('/data-table', function () {
    return view('page.data-table');
});

Route::get('/table', function () {
    return view('page.table');
});


//CRUD
//Create Data Cast
//Route yang mengarah ke form input tambah cast
Route::get('/cast/create', [CastController::class, 'create']);

//Route untuk mengirim inputan ke db table cast
Route::post('/cast', [CastController::class, 'store']);

//Read data cast
//route untuk menampilkan semua data di table cast ke blade
Route::get('/cast', [CastController::class, 'index']);

//Route untuk ambil detail data berdasarkan parameter id
Route::get('/cast/{id}', [CastController::class, 'show']);

//Route untuk update data yang mengarah ke form input edit dgn nilai berdasarkan params id
Route::get('/cast/{id}/edit', [CastController::class, 'edit']);
Route::put('/cast/{id}', [CastController::class, 'update']);

//route delete data
Route::delete('/cast/{id}', [CastController::class, 'destroy']);
