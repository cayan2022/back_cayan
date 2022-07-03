<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\Dashboard\{
    AuthController
};


Route::prefix('auth')
->as('auth.')
->group(function () {
    Route::post('login', [AuthController::class, 'login'])->name('login');
    Route::post('register', [AuthController::class, 'register'])->name('register');
   
});
