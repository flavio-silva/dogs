<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DogPhotoController;
use App\Http\Controllers\ForgotPasswordController;
use App\Http\Controllers\PhotoCommentController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


Route::group(['middleware' => ['auth:sanctum']], function () {
    Route::post('/{photo}/ comments/', [PhotoCommentController::class, 'store']);
    Route::get('/{photo}/ comments/', [PhotoCommentController::class, 'index']);

    Route::resource('photos', DogPhotoController::class);
});

Route::post('/forgot-password/email', [ForgotPasswordController::class, 'email']);
Route::post('/forgot-password/reset', [ForgotPasswordController::class, 'reset']);
Route::post('/auth/login', [AuthController::class, 'login']);
Route::post('/auth/register', [AuthController::class, 'register']);