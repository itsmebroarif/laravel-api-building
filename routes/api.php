<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth:sanctum'])->get('/user', function (Request $request) {
    return $request->user();
});

//Bagian Ini Berfungsi Untuk User Melakukan Pendaftaran Dan Juga Masuk
Route::post('/register', [App\Http\Controllers\API\AuthController::class, 'register']);
Route::post('/login', [App\Http\Controllers\API\AuthController::class, 'login']);

//Proteksi Router Yang Dibuat Dengan Middleware
Route::group(['middleware' => ['auth:sanctum']], function () {
    Route::get('/profile', function(Request $request) {
        return auth()->user();
    }); 

    // Bagian ini untuk menampilkan data gallery
    Route::resource('galleries', App\Http\Controllers\API\GalleryController::class);
    // Bagian ini untuk menampilkan data product
    Route::resource('products', App\Http\Controllers\API\ProductController::class);
    // Bagian ini untuk menampilkan data service
    Route::resource('services', App\Http\Controllers\API\ServiceController::class);

    // Bagian ini Digunakan Untuk User Logout
    Route::post('/logout', 
    [App\Http\Controllers\API\AuthController::class, 'logout']
    );
});