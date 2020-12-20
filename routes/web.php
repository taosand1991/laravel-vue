<?php

use App\Http\Controllers\HomeContoller;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
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

// Route::get('/', function () {
//     return view('welcome');
// });


Route::get('/{vue_capture?}', function () {
    return view('layouts.app');
})->where('vue_capture', '[\/\w\.-]*');

Route::view('/reset', 'welcome')->name('password.reset');

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');