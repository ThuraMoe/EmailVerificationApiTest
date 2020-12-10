<?php

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

Route::get('user/login', 'API\User\EmployeePersonalController@login');
Route::get('user/email/verify/{id}', 'API\User\VerificationController@verify')->name('verification.verify')->middleware('signed');;
Route::get('user/email/resend', 'API\User\VerificationController@resend')->name('verification.resend');

Route::middleware(['auth:api', 'verified'])->group(function() {
    Route::post('register', 'API\User\EmployeePersonalController@register');
    Route::get('details', 'API\User\EmployeePersonalController@details');
});
