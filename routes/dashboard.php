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
    OrderController

};
//route naming is need to make check_permissions middleware
Route::as('dashboard.')
    ->middleware(['auth:sanctum','check_permissions'])
    ->prefix('dashboard')
    ->group(function () {

        //profile
        Route::as('profiles.')
            ->prefix('profile')->group(function () {
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
            ->prefix('roles')->group(function () {
                Route::get('get-roles', [RolesController::class, 'getRoles'])->name('index');
                Route::get('get-role-permissions', [RolesController::class, 'getRolePermissions'])->name('show');
                Route::post('add-role', [RolesController::class, 'addRole'])->name('store');
                Route::post('assignRoleToUser', [RolesController::class, 'assignRoleToUser'])->name('assign');
                Route::get('edit/{role}', [RolesController::class, 'edit'])->name('edit');
                Route::post('update/{role}', [RolesController::class, 'update'])->name('update');
            });

        //Permissions
        Route::as('permissions.')
            ->prefix('permissions')->group(function () {
                Route::get('get-permissions', [RolesController::class, 'getPermissions'])->name('index');
                Route::post('add-permission', [RolesController::class, 'addPermission'])->name('store');
            });

        //pages
        Route::as('pages.')
            ->prefix('pages')->group(function () {
                /*doctors*/
                Route::group([], function (){
                    Route::put('doctors/{doctor}/block',[DoctorController::class,'block'])->name('doctors.block');
                    Route::put('doctors/{doctor}/active',[DoctorController::class,'active'])->name('doctors.active');
                    Route::post('doctors/{doctor}',[DoctorController::class,'update'])->name('doctors.update');
                    Route::apiResource('doctors',DoctorController::class)->except('update');
                });
                /*testimonials*/
                Route::group([], function (){
                    Route::put('testimonials/{testimonial}/block',[TestimonialController::class,'block'])->name('testimonials.block');
                    Route::put('testimonials/{testimonial}/active',[TestimonialController::class,'active'])->name('testimonials.active');
                    Route::post('testimonials/{testimonial}',[TestimonialController::class,'update'])->name('testimonials.update');
                    Route::apiResource('testimonials',TestimonialController::class)->except('update');
                });
                /*offers*/
                Route::group([], function (){
                    Route::put('offers/{offer}/block',[OfferController::class,'block'])->name('offers.block');
                    Route::put('offers/{offer}/active',[OfferController::class,'active'])->name('offers.active');
                    Route::post('offers/{offer}',[OfferController::class,'update'])->name('offers.update');
                    Route::apiResource('offers',OfferController::class)->except('update');
                });

                /*services*/
                Route::group([], function (){
                    Route::put('services/{service}/block',[ServiceController::class,'block'])->name('services.block');
                    Route::put('services/{service}/active',[ServiceController::class,'active'])->name('services.active');
                    Route::post('services/{service}',[ServiceController::class,'update'])->name('services.update');
                    Route::apiResource('services',ServiceController::class)->except('update');
                });

                /*categories*/
                Route::group([], function (){
                    Route::put('categories/{category}/block',[CategoryController::class,'block'])->name('categories.block');
                    Route::put('categories/{category}/active',[CategoryController::class,'active'])->name('categories.active');
                    Route::post('categories/{category}',[CategoryController::class,'update'])->name('categories.update');
                    Route::apiResource('categories',CategoryController::class)->except('update');
                });

                /*get substauses by status id*/
                Route::group([], function (){
                    Route::get('statuses/{status}/substatuses',[StatusController::class,'subStatuses'])->name('subStatuses');
                });

                /*Follow Order*/
                Route::group([], function (){
                    Route::post('orders/follow-order',[OrderController::class,'followOrder'])->name('followOrder');
                });

                Route::apiResources([
                    'sources' => SourceController::class,
                    'branches' => BranchController::class,
                    'orders' => OrderController::class,
                    'statuses' => StatusController::class,
                    'substatuses' => SubStatusController::class,
                    'settings' => SettingController::class,
                    'abouts' => AboutController::class,
                    'countries' => CountryController::class
                ]);
            });
    });
