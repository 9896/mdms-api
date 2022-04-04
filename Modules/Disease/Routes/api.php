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

/*
*ADMIN
 */
Route::group(['middleware' => 'auth:admins-api', 'prefix' => 'admin'], function(){
    Route::get('/diseases/get-all', 'DiseaseController@getAllDiseases');
    Route::get('/diseases/get-all-input', 'DiseaseController@getAllDiseasesUnpaginated');
    Route::get('/diseases/get-disease/{uuid}', 'DiseaseController@showDisease');
    Route::post('/diseases/store-disease', 'DiseaseController@storeDisease');
    Route::post('/diseases/delete-disease/{uuid}', 'DiseaseController@deleteDisease');
    Route::post('/diseases/get-diseases', 'DiseaseController@getDiseases');
    Route::post('/diseases/update-disease/{uuid}', 'DiseaseController@updateDisease');
    Route::post('/diseases/get-disease-by-symptoms', 'DiseaseController@diseaseBySymptoms');
    Route::get('/diseases/get-statistics', 'DiseaseController@getStatistics');
});


/**
 * DOCTOR
 */
Route::group(['middleware' => 'auth:doctors-api', 'prefix' => 'doctor'], function(){
    Route::get('/diseases/get-all', 'DiseaseController@getAllDiseases');
    Route::get('/diseases/get-disease/{uuid}', 'DiseaseController@showDisease');
    Route::post('/diseases/store-disease', 'DiseaseController@storeDisease')->middleware(['permission:CUD1']);
    Route::get('/diseases/delete-disease/{uuid}', 'DiseaseController@deleteDisease')->middleware(['permission:CUD1']);
    Route::post('/diseases/get-diseases', 'DiseaseController@getDiseases');
    Route::post('/diseases/update-disease/{uuid}', 'DiseaseController@updateDisease')->middleware(['permission:CUD1']);
    Route::post('/diseases/get-disease-by-symptoms', 'DiseaseController@diseaseBySymptoms');
    Route::get('/diseases/get-statistics', 'DiseaseController@getStatistics');

});

/**
 * PATIENT
 */
Route::group(['middleware' => 'auth:patients-api', 'prefix' => 'patient'], function(){
    Route::get('/diseases/get-all', 'DiseaseController@getAllDiseases');
    Route::get('/diseases/get-all-input', 'DiseaseController@getAllDiseasesUnpaginated');
    Route::get('/diseases/get-disease/{uuid}', 'DiseaseController@showDisease');
    Route::post('/diseases/get-diseases', 'DiseaseController@getDiseases');
    Route::post('/diseases/get-disease-by-symptoms', 'DiseaseController@diseaseBySymptoms');
});

/**
 * Unauthenticated Route
 */
//Route::post('/diseases/get-disease-by-symptoms', 'DiseaseController@diseaseBySymptoms');