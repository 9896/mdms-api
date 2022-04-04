<?php

use Illuminate\Http\Request;

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

Route::middleware('auth:api')->get('/doctor', function (Request $request) {
    return $request->user();
});

Route::group(['middleware' => 'auth:doctors-api'], function(){
    Route::get('/me', 'DoctorController@me');

});

Route::group(['middleware' => 'auth:admins-api'], function(){
   // Route::get('/me', 'DoctorController@me');
    Route::get('/doctors/get-all-doctors', 'DoctorController@getAllDoctors');
    Route::post('/doctors/store-doctor', 'DoctorController@storeDoctor');
    //Route::post('/doctors/update', 'DoctorController@update');

});

