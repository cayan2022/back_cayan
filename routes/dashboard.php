<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\Dashboard\{
    CountryController,
    RolesController,
    CategoryController,
    ServiceController,
    OfferController,
    DoctorController,
    SourceController,
    BranchController,
    StatusController,
    SubStatusController,
    SettingController,
    TestimonialController,
    AboutController,
    ProfileController,
    ChangePasswordController,
    EmolpyeeController

};

Route::as('dashboard.')
    ->middleware('auth:sanctum')
    ->prefix('dashboard')
    ->group(function () {
        //profile
        Route::as('profile.')
            ->prefix('profile')->group(function () {
                Route::get('me', [ProfileController::class, 'show'])->name('show');
                Route::post('update', [ProfileController::class, 'update'])->name('update');
                Route::post('logout', [ProfileController::class, 'logout'])->name('logout');
            });

        //changePassword
        Route::post('changePassword', [ChangePasswordController::class, 'changePassword'])->name('changePassword');

        //profile
        Route::as('profile.')
            ->prefix('profile')->group(function () {
                Route::get('all', [ProfileController::class, 'index'])->name('index');
                Route::get('show/{user}', [ProfileController::class, 'show'])->name('show');
                Route::post('store', [ProfileController::class, 'store'])->name('store')->withoutMiddleware('auth:sanctum');
                Route::post('update/{user}', [ProfileController::class, 'update'])->name('update');
                Route::post('logout/{user}', [ProfileController::class, 'logout'])->name('logout');
            });



        //Roles & Permissions Crud
        Route::as('roles.')
            ->prefix('roles')->group(function () {
                Route::get('get-roles', [RolesController::class, 'getRoles']);
                Route::get('get-permissions', [RolesController::class, 'getPermissions']);
                Route::get('get-role-permissions', [RolesController::class, 'getRolePermissions']);
                Route::post('add-permission', [RolesController::class, 'addPermission']);
                Route::post('add-role', [RolesController::class, 'addRole'])->name('role');
                Route::post('assignRoleToUser', [RolesController::class, 'assignRoleToUser']);
            });
        //pages
        Route::as('pages.')
            ->prefix('pages')->group(function () {
                Route::apiResources([
                    'categories' => CategoryController::class,
                    'services' => ServiceController::class,
                    'offers' => OfferController::class,
                    'doctors' => DoctorController::class,
                    'sources' => SourceController::class,
                    'branches' => BranchController::class,
                    'statuses' => StatusController::class,
                    'substatuses' => SubStatusController::class,
                    'settings' => SettingController::class,
                    'testimonials' => TestimonialController::class,
                    'abouts' => AboutController::class,
                    'countries' => CountryController::class
                ]);
            });
    });
