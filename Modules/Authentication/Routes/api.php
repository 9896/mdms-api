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

Route::middleware('auth:api')->get('/authentication', function (Request $request) {
    return $request->user();
});

//patient users register
Route::post('patients/register', 'RegisterController@register');

//admin users login
Route::post('admins/login', 'AuthenticationController@adminLogin')->name('Authentication::admin-login');

//doctor users login
Route::post('doctors/login', 'AuthenticationController@doctorLogin')->name('Authentication::doctor-login');

//patient users login
Route::post('patients/login', 'AuthenticationController@patientLogin')->name('Authentication::patient-login');

