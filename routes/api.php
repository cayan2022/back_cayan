<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\Dashboard\AuthController;
use Illuminate\Support\Str;
use App\Models;
use App\Http\Resources;
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

Route::prefix('auth')->as('auth.')->group(function () {

    Route::post('login', [AuthController::class, 'login'])->name('login');
    Route::post('register', [AuthController::class, 'register'])->name('register');


});
//until we put permissions Mr. hesham basha tarek ;)
//$pages=['category','service','offer','doctor','source','branch'];
//foreach ($pages as $page){
//    $model="\App\Models\\".Str::ucfirst($page);
//    $resourcClasse="\App\Http\Resources\\".Str::ucfirst($page)."Resource";
//    $resource=$model::paginate();
//    Route::get($page,function () use ($resource, $resourcClasse) {
//        return $resourcClasse::collection($resource);
//    });
//}
