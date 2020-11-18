<?php

use App\Http\Controllers\BookController;
use App\Http\Controllers\PassportController;
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
Route::post('/login', [PassportController::class, 'login'] );
Route::post('/register', [PassportController::class, 'register'] );


Route::middleware('auth:api')->group(function(){
    Route::get('/user', [PassportController::class, 'user'] );
    Route::resource('book', BookController::class);


});

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });
