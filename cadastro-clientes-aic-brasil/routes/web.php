<?php

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

Route::get('/', function () {
    return redirect('clients');
});

Route::get('/home/{name?}', "SiteController@home");
Route::get('/clients', [SiteController::class, 'clients'])->name('client.list');
Route::get('/clients/{id}', [SiteController::class, 'clientById'])->name('client.detail');
Route::get('/customers', [SiteController::class, 'customers'])->name('customer.list');
Route::get('/customers/{id}', [SiteController::class, 'customerById'])->name('customer.detail');
Route::get('/subscriptions', [SiteController::class, 'subscriptions'])->name('subscriptions.list');
Route::get('/subscriptions/{id:int}', [SiteController::class, 'subscriptionById'])->name('subscription.detail');
Route::get('/plans', [SiteController::class, 'getPlans'])->name('plans.list');
Route::post('/plans', [SiteController::class, 'addPlan'])->name('plans.add');
Route::post('/plans/activate', [SiteController::class, 'activatePlan'])->name('plans.activate');
Route::post('/plans/deactivate', [SiteController::class, 'deactivatePlan'])->name('plans.deactivate');
Route::post('/client/integrate', [SiteController::class, 'integrateClientFromGalaxPay'])->name('client.integrate');
Route::post('/subscription/add', [SiteController::class, 'addSubscriptionById'])->name('subscription.add');
Route::get('/batch', [SiteController::class, 'integrateSubscriptionsInBatch'])->name('subscription.integrate');
Route::get('/logs', [SiteController::class, 'getLogs'])->name('logs.list');
