<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\Site\{BlogController,
    CategoryController,
    OrderController,
    PartnerController,
    PaymentController,
    ProjectController,
    ServiceController,
    OfferController,
    SeoPageController,
    DoctorController,
    AboutController,
    BranchController,
    SettingController,
    SourceController,
    TestimonialController,
    TidingController,
    PortfolioCategoryController,
    PortfolioController,
    SourceClickController};


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

require __DIR__ . '/auth.php';
require __DIR__ . '/dashboard.php';

Route:: as('site.')
    ->prefix('site')->group(function () {
        Route::get('categories', CategoryController::class)->name('categories');
        Route::get('sources', SourceController::class)->name('sources');
        Route::get('branches', BranchController::class)->name('branches');
        Route::get('services', ServiceController::class)->name('services');
        Route::get('offers', OfferController::class)->name('offers');
        Route::get('doctors', DoctorController::class)->name('doctors');
        Route::get('abouts', AboutController::class)->name('abouts');
        Route::get('branches', BranchController::class)->name('branches');
        Route::get('testimonials', TestimonialController::class)->name('testimonials');
        Route::get('blogs', BlogController::class)->name('blogs');
        Route::get('blogs/{slug}', [BlogController::class, 'show'])->name('show-blog');
        Route::get('getBlogsByTag/{tag}', [BlogController::class, 'getBlogsByTag'])->name('getBlogsByTag');
        Route::get('partners', PartnerController::class)->name('partners');
        Route::get('projects', ProjectController::class)->name('projects');
        Route::get('tidings', TidingController::class)->name('tidings');
        Route::get('settings/{setting}', SettingController::class)->name('settings');
        Route::post('settings/click/register', [SettingController::class, 'clickRegister'])->name('settings.click.register');
        Route::post('order', OrderController::class)->name('order.store');
        Route::post('saas_order', [OrderController::class, 'storeSaasOrder'])->name('saas_order.store');
        Route::get('portfolio-categories', PortfolioCategoryController::class)->name('portfolio-categories');
        Route::get('portfolios', PortfolioController::class)->name('portfolios');
        Route::get('seo_pages', [SeoPageController::class, 'index'])->name('seo-pages');

        // source clicks
        Route::post('add_click', [SourceClickController::class, 'addClick'])->name('add-click');

        // update tenant
        Route::post('renewUserTenant', [PaymentController::class,'renewTenant']);
    });


Route::post('getSessionIdMyFatoorah', [PaymentController::class,'getSessionId']);
Route::post('getInvoice', [PaymentController::class,'getInvoice']);




