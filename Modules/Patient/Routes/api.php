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

Route::middleware('auth:api')->get('/patient', function (Request $request) {
    return $request->user();
});

Route::group(['middleware' => 'auth:patients-api'], function(){
    Route::get('/me', 'PatientController@me');
    Route::get('/get-patient', 'PatientController@showPatient');
    Route::post('/update-patient', 'PatientController@updatePatient');
    Route::post('/patients/store-patient', 'PatientController@storePatient');
});