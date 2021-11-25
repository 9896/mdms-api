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

Route::group(['middleware' => 'auth:admins-api'], function(){
    Route::get('/me', 'AdminController@me');

    Route::post('/admins/revoke-doctor-cud/{uuid}', 'AdminController@revokeDoctorCUD');
    Route::post('/admins/grant-doctor-cud/{uuid}', 'AdminController@grantDoctorCUD');

    Route::post('/admins/revoke-doctor-login/{uuid}', 'AdminController@revokeDoctorLogin');
    Route::post('/admins/grant-doctor-login', 'AdminController@grantDoctorLogin');

    Route::post('/admins/revoke-patient-login/{uuid}', 'AdminController@revokePatientLogin');
    Route::post('/admins/grant-patient-login', 'AdminController@grantPatientLogin');

});