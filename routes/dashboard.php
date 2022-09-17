<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\Dashboard\{BlogController,
    RolesController,
    OfferController,
    AboutController,
    OrderController,
    DoctorController,
    SourceController,
    BranchController,
    StatusController,
    TidingController,
    CountryController,
    PartnerController,
    ServiceController,
    SettingController,
    ProfileController,
    CustomerController,
    CategoryController,
    SubStatusController,
    TestimonialController,
    ExportOrdersController,
    ChangePasswordController,
    Reports\StatusesReportController,
    Reports\SourcesReportController,
    Reports\ModeratorsReportController
};

//route naming is need to make check_permissions middleware
Route::as('dashboard.')
    ->middleware(['auth:sanctum', 'check_permissions'])
    ->prefix('dashboard')
    ->group(function () {
        //profile
        Route::as('profiles.')
            ->prefix('profile')
            ->group(function () {
                Route::get('all', [ProfileController::class, 'index'])->name('index');
                Route::get('getCustomerPatients', [ProfileController::class, 'getCustomerPatients'])->name('getCustomerPatients');
                Route::get('show/{user}', [ProfileController::class, 'show'])->name('show');
                Route::post('store', [ProfileController::class, 'store'])->name('store');
                Route::post('update/{user}', [ProfileController::class, 'update'])->name('update');
                Route::post('change-password', ChangePasswordController::class)->name('changepassword');
                Route::post('logout/{user}', [ProfileController::class, 'logout'])->name('logout');
                Route::post('block/{user}', [ProfileController::class, 'block'])->name('block');
                Route::post('active/{user}', [ProfileController::class, 'active'])->name('active');
            });

        //Roles
        Route::as('roles.')
            ->prefix('roles')
            ->group(function () {
                Route::get('get-roles', [RolesController::class, 'getRoles'])->name('index');
                Route::get('get-role-permissions', [RolesController::class, 'getRolePermissions'])->name('show');
                Route::post('add-role', [RolesController::class, 'addRole'])->name('store');
                Route::post('assignRoleToUser', [RolesController::class, 'assignRoleToUser'])->name('assign');
                Route::get('edit/{role}', [RolesController::class, 'edit'])->name('edit');
                Route::post('update/{role}', [RolesController::class, 'update'])->name('update');
            });

        //Permissions
        Route::as('permissions.')
            ->prefix('permissions')
            ->group(function () {
                Route::get('get-permissions', [RolesController::class, 'getPermissions'])->name('index');
                Route::post('add-permission', [RolesController::class, 'addPermission'])->name('store');
            });

        //pages
        Route::as('pages.')
            ->prefix('pages')
            ->group(function () {
                /*doctors*/
                Route::group([], function () {
                    Route::put('doctors/{doctor}/block', [DoctorController::class, 'block'])->name('doctors.block');
                    Route::put('doctors/{doctor}/active', [DoctorController::class, 'active'])->name('doctors.active');
                    Route::post('doctors/{doctor}', [DoctorController::class, 'update'])->name('doctors.update');
                    Route::apiResource('doctors', DoctorController::class)->except('update');
                });
                /*testimonials*/
                Route::group([], function () {
                    Route::put('testimonials/{testimonial}/block', [TestimonialController::class, 'block'])->name(
                        'testimonials.block'
                    );
                    Route::put('testimonials/{testimonial}/active', [TestimonialController::class, 'active'])->name(
                        'testimonials.active'
                    );
                    Route::post('testimonials/{testimonial}', [TestimonialController::class, 'update'])->name(
                        'testimonials.update'
                    );
                    Route::apiResource('testimonials', TestimonialController::class)->except('update');
                });
                /*offers*/
                Route::group([], function () {
                    Route::put('offers/{offer}/block', [OfferController::class, 'block'])->name('offers.block');
                    Route::put('offers/{offer}/active', [OfferController::class, 'active'])->name('offers.active');
                    Route::post('offers/{offer}', [OfferController::class, 'update'])->name('offers.update');
                    Route::apiResource('offers', OfferController::class)->except('update');
                });

                /*services*/
                Route::group([], function () {
                    Route::put('services/{service}/block', [ServiceController::class, 'block'])->name('services.block');
                    Route::put('services/{service}/active', [ServiceController::class, 'active'])->name(
                        'services.active'
                    );
                    Route::post('services/{service}', [ServiceController::class, 'update'])->name('services.update');
                    Route::apiResource('services', ServiceController::class)->except('update');
                });
                /*tidings || news*/
                Route::group([], function () {
                    Route::put('tidings/{tiding}/active', [TidingController::class, 'active'])->name('tidings.active');
                    Route::post('tidings/{tiding}', [TidingController::class, 'update'])->name('tidings.update');
                    Route::apiResource('tidings', TidingController::class)->except('update');
                });

                /*categories*/
                Route::group([], function () {
                    Route::put('categories/{category}/block', [CategoryController::class, 'block'])->name(
                        'categories.block'
                    );
                    Route::put('categories/{category}/active', [CategoryController::class, 'active'])->name(
                        'categories.active'
                    );
                    Route::post('categories/{category}', [CategoryController::class, 'update'])->name(
                        'categories.update'
                    );
                    Route::apiResource('categories', CategoryController::class)->except('update');
                });

                /*get substauses by status id*/
                Route::group([], function () {
                    Route::get('statuses/{status}/substatuses', [StatusController::class, 'subStatuses'])->name(
                        'subStatuses'
                    );
                });

                /*Follow Order*/
                Route::group([], function () {
                    Route::post('orders/follow-order', [OrderController::class, 'followOrder'])->name('followOrder');
                });

                /*Customers*/
                Route::as('customers.')->prefix('customers')->group(function () {
                    Route::put('block/{user}', [CustomerController::class, 'block'])->name('block');
                    Route::put('active/{user}', [CustomerController::class, 'active'])->name('active');
                    Route::get('all', [CustomerController::class, 'index'])->name('index');
                    Route::post('store', [CustomerController::class, 'store'])->name('store');
                    Route::get('show/{user}', [CustomerController::class, 'show'])->name('show');
                    Route::post('update/{user}', [CustomerController::class, 'update'])->name('update');
                    Route::delete('delete/{user}', [CustomerController::class, 'destroy'])->name('destroy');
                });

                /*Blogs*/
                Route::as('blogs.')->prefix('blogs')->group(function () {
                    Route::put('block/{blog}', [BlogController::class, 'block'])->name('block');
                    Route::put('active/{blog}', [BlogController::class, 'active'])->name('active');
                    Route::get('all', [BlogController::class, 'index'])->name('index');
                    Route::post('store', [BlogController::class, 'store'])->name('store');
                    Route::get('show/{blog}', [BlogController::class, 'show'])->name('show');
                    Route::post('update/{blog}', [BlogController::class, 'update'])->name('update');
                    Route::delete('delete/{blog}', [BlogController::class, 'destroy'])->name('destroy');
                });

                /*Abouts*/
                Route::as('abouts.')->prefix('abouts')->group(function () {
                    Route::put('block/{about}', [AboutController::class, 'block'])->name('block');
                    Route::put('active/{about}', [AboutController::class, 'active'])->name('active');
                    Route::get('all', [AboutController::class, 'index'])->name('index');
                    Route::post('store', [AboutController::class, 'store'])->name('store');
                    Route::get('show/{about}', [AboutController::class, 'show'])->name('show');
                    Route::post('update/{about}', [AboutController::class, 'update'])->name('update');
                    Route::delete('delete/{about}', [AboutController::class, 'destroy'])->name('destroy');
                });

                /*Partners*/
                Route::as('partners.')->prefix('partners')->group(function () {
                    Route::put('block/{partner}', [PartnerController::class, 'block'])->name('block');
                    Route::put('active/{partner}', [PartnerController::class, 'active'])->name('active');
                    Route::get('all', [PartnerController::class, 'index'])->name('index');
                    Route::post('store', [PartnerController::class, 'store'])->name('store');
                    Route::get('show/{partner}', [PartnerController::class, 'show'])->name('show');
                    Route::post('update/{partner}', [PartnerController::class, 'update'])->name('update');
                    Route::delete('delete/{partner}', [PartnerController::class, 'destroy'])->name('destroy');
                });

                Route::get('orders/export', ExportOrdersController::class)->name('orders.export');

                Route::apiResources([
                    'sources' => SourceController::class,
                    'branches' => BranchController::class,
                    'orders' => OrderController::class,
                    'statuses' => StatusController::class,
                    'substatuses' => SubStatusController::class,
                    'settings' => SettingController::class,
                    'countries' => CountryController::class,
                ]);
            });

        //reports
        Route::as('reports.')->prefix('reports')->group(function () {
            Route::get('sources', SourcesReportController::class)->name('sources');
            Route::get('moderators',ModeratorsReportController::class)->name('moderators');
            Route::get('statuses',StatusesReportController::class)->name('statuses');
        });
    });
