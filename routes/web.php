<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\SchoolController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\LocalityController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProvisionController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\SchoolYearController;
use App\Http\Controllers\ViewSchoolController;
use App\Http\Controllers\DoubleRecordController;
use App\Http\Controllers\AnonymizationController;
use App\Http\Controllers\LeavesTerminationController;

Route::group(['middleware' => ['guest']], function () {
    Route::get('/', [LoginController::class, 'loginForm']);
    Route::get('/login', [LoginController::class, 'loginForm'])->name('login.form');
    Route::post('/login', [LoginController::class, 'login'])->name('login');
});

Route::group(['middleware' => ['auth', '2fa']], function () {
    Route::post('2fa', function() {
        return redirect()->intended();
    })->name('2fa');

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::group(['prefix' => 'profile'], function () {
        Route::get('/', [ProfileController::class, 'index'])->name('profile');
        Route::get('/edit', [ProfileController::class, 'edit'])->name('profile.edit');
        Route::get('/password', [ProfileController::class, 'password'])->name('profile.password');
        Route::post('/password', [ProfileController::class, 'changePassword'])->name('profile.change.password');
        
        Route::patch('/profile/tfa-generate', [ProfileController::class, 'generateTFA'])->name('profile.tfa.generate');
        Route::patch('/profile/enable-tfa/{secret_key}', [ProfileController::class, 'enableTFA'])->name('profile.enable.tfa');
        Route::patch('/profile/disable-tfa', [ProfileController::class, 'disableTFA'])->name('profile.disable.tfa');
    });

    Route::name('admin.')->group(function () {
        Route::group(['prefix' => 'admin'], function () {

            Route::group(['prefix' => 'customers'], function () {
                Route::get('/', [CustomerController::class, 'index'])->name('customers.all');
                Route::post('/', [CustomerController::class, 'store'])->name('customer.store');
                Route::get('/comments', [CustomerController::class, 'indexComments'])->name('customers.all.comments');
                Route::post('/comments', [CustomerController::class, 'storeComment'])->name('customer.store.comment');
            });

            Route::group(['prefix' => 'users'], function () {
                Route::get('/', [UserController::class, 'index'])->name('users');
                Route::post('/', [UserController::class, 'store'])->name('users.store');
                Route::get('/{id}/edit', [UserController::class, 'edit'])->name('users.edit');
                Route::post('/{id}/edit', [UserController::class, 'update'])->name('users.update');
                Route::delete('/{id}/delete', [UserController::class, 'destroy'])->name('users.delete');
            });
        });
    });

    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

});
