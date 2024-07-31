<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\BiodataController;

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
