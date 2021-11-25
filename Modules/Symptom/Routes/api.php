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

Route::middleware('auth:api')->get('/symptom', function (Request $request) {
    return $request->user();
});
/**
 * ADMIN
 */
Route::group(['middleware' => 'auth:admins-api', 'prefix' => 'admin'], function(){
    Route::get('/symptoms/get-all/{get?}', 'SymptomController@getAllSymptoms');
    Route::get('/symptoms/get-symptom/{uuid}', 'SymptomController@showSymptom');
    Route::post('/symptoms/store-symptom', 'SymptomController@storeSymptom');
    Route::post('/symptoms/delete-symptom/{uuid}', 'SymptomController@deleteSymptom');
    Route::post('/symptoms/get-symptoms', 'SymptomController@getSymptoms');
    Route::post('/symptoms/update-symptom/{uuid}', 'SymptomController@updateSymptom');
    Route::post('/symptoms/track-symptom', 'SymptomController@trackSymptom');
    Route::get('/symptoms/get-tracked-symptoms', 'SymptomController@getTrackedSymptoms');
    Route::get('/symptoms/get-tracked-symptom/{uuid}', 'SymptomController@getTrackedSymptom');
    Route::post('/symptoms/edit-tracked-symptom', 'SymptomController@EditTrackedSymptom');
    Route::post('/symptoms/delete-tracked-symptom/{uuid}/{created_at}', 'SymptomController@deleteTrackedSymptom');
});

/**
 * DOCTOR
 */
Route::group(['middleware' => 'auth:doctors-api', 'prefix' => 'doctor'], function(){
    Route::get('/symptoms/get-all', 'SymptomController@getAllSymptoms');
    Route::get('/symptoms/get-symptom/{uuid}', 'SymptomController@showSymptom');
    Route::post('/symptoms/store-symptom', 'SymptomController@storeSymptom')->middleware(['permission:CUD1']);
    Route::get('/symptoms/delete-symptom/{uuid}', 'SymptomController@deleteSymptom')->middleware(['permission:CUD1']);
    Route::post('/symptoms/get-symptoms', 'SymptomController@getSymptoms');
    Route::post('/symptoms/update-symptom/{uuid}', 'SymptomController@updateSymptom')->middleware(['permission:CUD1']);
    Route::post('/symptoms/track-symptom', 'SymptomController@trackSymptom');
    Route::get('/symptoms/show-tracked-symptom/{uuid}/{created_at}', 'SymptomController@showTrackedSymptom');
    Route::get('/symptoms/get-tracked-symptoms', 'SymptomController@getTrackedSymptoms');
    Route::get('/symptoms/get-tracked-symptom/{uuid}', 'SymptomController@getTrackedSymptom');
    Route::post('/symptoms/edit-tracked-symptom', 'SymptomController@EditTrackedSymptom');
    Route::post('/symptoms/delete-tracked-symptom/{uuid}/{created_at}', 'SymptomController@deleteTrackedSymptom');
});

/**
 * PATIENT
 */
Route::group(['middleware' => 'auth:patients-api', 'prefix' => 'patient'], function(){
    Route::post('/symptoms/get-symptoms', 'SymptomController@getSymptoms');
    Route::post('/symptoms/track-symptom', 'SymptomController@trackSymptom');
    Route::get('/symptoms/get-tracked-symptoms', 'SymptomController@getTrackedSymptoms');
    Route::get('/symptoms/get-tracked-symptom/{uuid}', 'SymptomController@getTrackedSymptom');
});

/**
 * Fallback
 */
Route::fallback(function(){
    return response()->json([
        'message' => 'Page Not Found. If error persists, contact info@website.com'], 404);
});