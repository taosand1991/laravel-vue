<?php

use App\Http\Controllers\ForgotController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;
use App\Http\Controllers\UserController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group(['middleware' => ['auth:sanctum']], function () {
    Route::get('/posts', [PostController::class, 'index']);
    Route::post('/post/create', [PostController::class, 'store']);
    Route::get('/post/{post:id}', [PostController::class, 'getPost']);
    Route::get('/post/delete/{post:id}', [PostController::class, 'deletePost']);
    Route::put('/post/edit/{id}', [PostController::class, 'editPost']);
});

Route::post('/create', [UserController::class, 'store']);
Route::post('/forgot', [ForgotController::class, 'forgotPassword']);
Route::post('/reset', [ForgotController::class, 'resetPassword']);
Route::get('/users', [UserController::class, 'getUsers']);
Route::post('/login', [UserController::class, 'login']);