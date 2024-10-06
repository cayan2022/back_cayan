<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\Site\{
    BlogController,
    CategoryController,
    OrderController,
    PartnerController,
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
    SourceClickController
};


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
        Route::get('portfolio-categories', PortfolioCategoryController::class)->name('portfolio-categories');
        Route::get('portfolios', PortfolioController::class)->name('portfolios');
        Route::get('seo_pages', [SeoPageController::class, 'index'])->name('seo-pages');

        // source clicks
        Route::post('add_click', [SourceClickController::class, 'addClick'])->name('add-click');
    });


Route::post('getSessionIdMyFatoorah', function () {

    $token = 'rLtt6JWvbUHDDhsZnfpAhpYk4dxYDQkbcPTyGaKp2TYqQgG7FGZ5Th_WD53Oq8Ebz6A53njUoo1w3pjU1D4vs_ZMqFiz_j0urb_BH9Oq9VZoKFoJEDAbRZepGcQanImyYrry7Kt6MnMdgfG5jn4HngWoRdKduNNyP4kzcp3mRv7x00ahkm9LAK7ZRieg7k1PDAnBIOG3EyVSJ5kK4WLMvYr7sCwHbHcu4A5WwelxYK0GMJy37bNAarSJDFQsJ2ZvJjvMDmfWwDVFEVe_5tOomfVNt6bOg9mexbGjMrnHBnKnZR1vQbBtQieDlQepzTZMuQrSuKn-t5XZM7V6fCW7oP-uXGX-sMOajeX65JOf6XVpk29DP6ro8WTAflCDANC193yof8-f5_EYY-3hXhJj7RBXmizDpneEQDSaSz5sFk0sV5qPcARJ9zGG73vuGFyenjPPmtDtXtpx35A-BVcOSBYVIWe9kndG3nclfefjKEuZ3m4jL9Gg1h2JBvmXSMYiZtp9MR5I6pvbvylU_PP5xJFSjVTIz7IQSjcVGO41npnwIxRXNRxFOdIUHn0tjQ-7LwvEcTXyPsHXcMD8WtgBh-wxR8aKX7WPSsT1O8d8reb2aR7K3rkV3K82K_0OgawImEpwSvp9MNKynEAJQS6ZHe_J_l77652xwPNxMRTMASk1ZsJL';
    $response = Http::withToken($token, 'Bearer')
        ->post('https://apitest.myfatoorah.com/v2/InitiateSession', [
            'CustomerIdentifier' => request()->customer_id,
        ]);
    if ($response->successful()) {
        return $response->json();
    }
    abort($response->status(), 'Error during request.');
});
