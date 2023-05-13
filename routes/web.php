<?php

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
Route::get('/', function () {
    if (Auth::check()) {
        return redirect(Auth::user()->role.'/dashboard');
    } else {
        return view('auth.login');
    }
});
Route::match(['GET', "POST"],'status', [App\Http\Controllers\AjaxController::class, 'toggleStatus'])->name('status');
Route::get('logout', [App\Http\Controllers\HomeController::class, 'logout'])->name('custom.logout');
Route::match(['GET','POST'],'change/password', [App\Http\Controllers\HomeController::class, 'changePassword'])->name('change.password');
Route::get('worker/{slug}/show', [App\Http\Controllers\WorkerController::class, 'showOnScan'])->name('show.worker')->middleware(['auth', 'verify.scanner']);

    // privacyPolicy Route
    Route::get('privacy/policy', function () {
        return view('privacy_policy');
    })->name('privacy.policy');
