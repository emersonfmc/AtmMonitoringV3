<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\SettingsController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Auth::routes();

Route::get('/', [App\Http\Controllers\HomeController::class, 'root'])->name('root');

//Update User Details
Route::post('/update-profile/{id}', [App\Http\Controllers\HomeController::class, 'updateProfile'])->name('updateProfile');
Route::post('/update-password/{id}', [App\Http\Controllers\HomeController::class, 'updatePassword'])->name('updatePassword');

// Route::get('{any}', [App\Http\Controllers\HomeController::class, 'index'])->name('index');

//Language Translation
Route::get('index/{locale}', [App\Http\Controllers\HomeController::class, 'lang']);


Route::group(['middleware' => ['auth:sanctum']], function () {
    Route::controller(UserController::class)->group(function () {
        Route::get('/users/page', 'users_page')->name('users.page');
        Route::get('/users/data', 'users_data')->name('users.data');
    });
});

Route::group(['middleware' => ['auth:sanctum'], 'prefix' => 'settings'], function () {
    Route::controller(SettingsController::class)->group(function () {
        Route::get('/districts', 'districts_page')->name('settings.district.page');
        Route::get('/districts/data', 'districts_data')->name('settings.district.data');

        Route::get('/users_group_page', 'users_group_page')->name('settings.users.group.page');
        Route::get('/users_group_data', 'users_group_data')->name('settings.users.group.data');

        Route::get('/area_page', 'area_page')->name('settings.area.page');
        Route::get('/area_data', 'area_data')->name('settings.area.data');

        Route::get('/branch_page', 'branch_page')->name('settings.branch.page');
        Route::get('/branch_data', 'branch_data')->name('settings.branch.data');

        Route::get('/bank_page', 'bank_page')->name('settings.bank.page');
        Route::get('/bank_data', 'bank_data')->name('settings.bank.data');

        Route::get('/pension_types/page', 'pension_types_page')->name('settings.pension.types.page');
        Route::get('/pension_types/data', 'pension_types_data')->name('settings.pension.types.data');
    });
});


Route::group(['middleware' => ['auth:sanctum']], function () {
    Route::controller(DashboardController::class)->group(function () {
        Route::get('/index', 'dashboard')->name('dashboard');
        // Route::resource('products', ProductController::class);
    });
});
