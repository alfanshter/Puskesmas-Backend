<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DamController;
use App\Http\Controllers\TpmControlller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/login', [AuthController::class, 'login']);
Route::post('/register', [AuthController::class, 'register']);
Route::get('/getakunall', [AuthController::class, 'getakunall']);
Route::get('/detailakun/{id?}', [AuthController::class, 'detailakun']);
Route::post('/hapusakun', [AuthController::class, 'hapusakun']);
Route::post('/updateakun', [AuthController::class, 'updateakun']);
Route::post('/updatepasswordamin', [AuthController::class, 'updatepasswordamin']);

Route::post('/inserttpm', [TpmControlller::class, 'inserttpm']);
Route::post('/updatetpm', [TpmControlller::class, 'updatetpm']);
Route::post('/deletetpm', [TpmControlller::class, 'deletetpm']);
Route::get('/readtpmall', [TpmControlller::class, 'readtpmall']);
Route::get('/readtpmdesa/{desa?}', [TpmControlller::class, 'readtpmdesa']);
Route::get('/readtpmdetail/{id?}', [TpmControlller::class, 'readtpmdetail']);
Route::get('/getdatatpm/{desa?}', [TpmControlller::class, 'getdatatpm']);

Route::post('/insertdam', [DamController::class, 'insertdam']);
Route::post('/updatedam', [DamController::class, 'updatedam']);
Route::post('/deletedam', [DamController::class, 'deletedam']);
Route::get('/readdamall', [DamController::class, 'readdamall']);
Route::get('/readdamdesa/{desa?}', [DamController::class, 'readdamdesa']);
Route::get('/readdamdetail/{id?}', [DamController::class, 'readdamdetail']);
Route::get('/getdatadam/{desa?}', [DamController::class, 'getdatadam']);
Route::post('/logout', [AuthController::class, 'logout']);