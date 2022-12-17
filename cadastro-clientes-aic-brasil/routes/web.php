<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\SiteController;
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

Route::get('/', "SiteController@home");

Route::prefix("admin")->group(function(){
    Route::get('/clients', [AdminController::class, 'clients'])->name('client.list');
    Route::get('/clients/{id}', [AdminController::class, 'clientById'])->name('client.detail');
    Route::get('/customers', [AdminController::class, 'customers'])->name('customer.list');
    Route::get('/customers/{id}', [AdminController::class, 'customerById'])->name('customer.detail');
    Route::get('/subscriptions', [AdminController::class, 'subscriptions'])->name('subscriptions.list');
    Route::get('/subscriptions/{id:int}', [AdminController::class, 'subscriptionById'])->name('subscription.detail');
    Route::get('/plans', [AdminController::class, 'getPlans'])->name('plans.list');
    Route::post('/plans', [AdminController::class, 'addPlan'])->name('plans.add');
    Route::post('/plans/activate', [AdminController::class, 'activatePlan'])->name('plans.activate');
    Route::post('/plans/deactivate', [AdminController::class, 'deactivatePlan'])->name('plans.deactivate');
    Route::post('/client/integrate', [AdminController::class, 'integrateClientFromGalaxPay'])->name('client.integrate');
    Route::post('/subscription/add', [AdminController::class, 'addSubscriptionById'])->name('subscription.add');
    Route::get('/batch', [AdminController::class, 'integrateSubscriptionsInBatch'])->name('subscription.integrate');
    Route::get('/batch/inactive', [AdminController::class, 'integrateDelayedClientsInBatch']);
    Route::get('/logs', [AdminController::class, 'getLogs'])->name('logs.list');
});
