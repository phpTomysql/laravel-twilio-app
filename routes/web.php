<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CallResponderController;
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
    return view('welcome');
});


Route::post('/twilio/webhook',[CallResponderController::class, 'index']);
Route::post('/twilio/webhook/q1',[CallResponderController::class, 'q1']);
Route::post('/twilio/webhook/q2',[CallResponderController::class, 'q2']);
Route::post('/twilio/webhook/q3',[CallResponderController::class, 'q3']);