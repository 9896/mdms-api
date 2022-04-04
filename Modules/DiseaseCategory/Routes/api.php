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

/**
 * ADMIN
 */
Route::group(['middleware' => 'auth:admins-api', 'prefix' => 'admin'], function(){
    Route::get('/disease-categories/get-all', 'DiseaseCategoryController@getAllDiseaseCategories');
    Route::get('/disease-categories/get-disease-category/{uuid}', 'DiseaseCategoryController@showDiseaseCategory');
    Route::post('/disease-categories/store-disease-category', 'DiseaseCategoryController@storeDiseaseCategory');
    Route::get('/disease-categories/delete-disease-category/{uuid}', 'DiseaseCategoryController@deleteDiseaseCategory');
    Route::post('/disease-categories/get-disease-categories', 'DiseaseCategoryController@getDiseaseCategories');
    Route::post('/disease-categories/update-disease-category/{uuid}', 'DiseaseCategoryController@updateDiseaseCategory');

});

/**
 * DOCTOR
 */
Route::group(['middleware' => 'auth:doctors-api', 'prefix' => 'doctor'], function(){
    Route::get('/disease-categories/get-all', 'DiseaseCategoryController@getAllDiseaseCategories');
    Route::get('/disease-categories/get-disease-category/{uuid}', 'DiseaseCategoryController@showDiseaseCategory');
    Route::post('/disease-categories/store-disease-category', 'DiseaseCategoryController@storeDiseaseCategory');
    Route::get('/disease-categories/delete-disease-category/{uuid}', 'DiseaseCategoryController@deleteDiseaseCategory');
    Route::post('/disease-categories/get-disease-categories', 'DiseaseCategoryController@getDiseaseCategories');
    Route::post('/disease-categories/update-disease-category/{uuid}', 'DiseaseCategoryController@updateDiseaseCategory');
});

/**
 * PATIENT
 */
Route::group(['middleware' => 'auth:patients-api', 'prefix' => 'patient'], function(){
    Route::post('/disease-categories/get-disease-categories', 'DiseaseCategoryController@getDiseaseCategories');
});