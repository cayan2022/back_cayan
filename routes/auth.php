<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\Dashboard\{
    LoginController
};


Route::prefix('auth')
->as('auth.')
->group(function () {
    Route::post('login', LoginController::class)->name('login');
});
