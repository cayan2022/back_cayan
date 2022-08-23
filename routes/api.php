<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\Site\{CategoryController,
    OrderController,
    ServiceController,
    OfferController,
    DoctorController,
    AboutController,
    BranchController,
    TestimonialController};


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

require __DIR__.'/auth.php';
require __DIR__.'/dashboard.php';

Route::as('site.')
    ->prefix('site')->group(function () {
    Route::get('categories', CategoryController::class)->name('categories');
    Route::get('services', ServiceController::class)->name('services');
    Route::get('offers', OfferController::class)->name('offers');
    Route::get('doctors', DoctorController::class)->name('doctors');
    Route::get('abouts', AboutController::class)->name('abouts');
    Route::get('branches', BranchController::class)->name('branches');
    Route::get('testimonials', TestimonialController::class)->name('testimonials');
    Route::post('order', OrderController::class)->name('order.store');
});
