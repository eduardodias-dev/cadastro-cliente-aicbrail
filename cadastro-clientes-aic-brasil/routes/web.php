<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SiteController;
use App\Http\Controllers\AdminController;

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

Route::prefix("admin")->middleware('auth')->group(function(){
    Route::get('', function () {
        return redirect('/admin/clients');
    });
    Route::get('/clients', [AdminController::class, 'clients'])->name('client.list');
    Route::get('/clients/{id}', [AdminController::class, 'clientById'])->name('client.detail');
    // Route::get('/customers', [AdminController::class, 'customers'])->name('customer.list');
    // Route::get('/customers/{id}', [AdminController::class, 'customerById'])->name('customer.detail');
    // Route::get('/subscriptions', [AdminController::class, 'subscriptions'])->name('subscriptions.list');
    // Route::get('/subscriptions/{id:int}', [AdminController::class, 'subscriptionById'])->name('subscription.detail');
    // Route::post('/subscription/add', [AdminController::class, 'addSubscriptionById'])->name('subscription.add');
    Route::get('/plans', [AdminController::class, 'getPlans'])->name('plans.list');
    Route::post('/plans', [AdminController::class, 'addPlan'])->name('plans.add');
    Route::post('/plans/activate', [AdminController::class, 'activatePlan'])->name('plans.activate');
    Route::post('/plans/deactivate', [AdminController::class, 'deactivatePlan'])->name('plans.deactivate');
    Route::post('/client/integrate', [AdminController::class, 'integrateClientFromGalaxPay'])->name('client.integrate');
    Route::get('/batch', [AdminController::class, 'integrateSubscriptionsInBatch'])->name('subscription.integrate');
    Route::get('/batch/inactive', [AdminController::class, 'integrateDelayedClientsInBatch']);
    Route::get('/logs', [AdminController::class, 'getLogs'])->name('logs.list');
    Route::get('/pacotes', [AdminController::class, 'pacotes'])->name('pacotes.list');
    Route::get('/pacotes/{id}', [AdminController::class, 'pacotesById'])->name('pacotes.detail');
    Route::get('/afiliados', [AdminController::class, 'afiliados'])->name('afiliados.list');
    Route::post('/afiliados/novo-codigo', [AdminController::class, 'novoAfiliado'])->name('afiliados.novo');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
Route::get('/comprar-plano/{id_plano}', [SiteController::class, 'comprar_plano'])->name('site.comprar_plano');
//Route::post('/checkout', [SiteController::class, 'checkout_post'])->name('checkout.post');
Route::get('/vieworder', [SiteController::class, 'view_pacote'])->name('view.order');
Route::post('/vieworder', [SiteController::class, 'view_order_post'])->name('view.order.post');

Route::get('/pdf/{ordercode}/{sendEmail?}', 'HomeController@pdf');
// Route::post('/viewContract/{ordercode}/{sendEmail?}/{showReport?}', 'SiteController@view_contract');
//Route::post('transaction/update', 'SiteController@updateTransaction');
Route::get('check/queue', 'JobsController@verificarFilaAssinaturas');
Route::get('carrinho','SiteController@cart')->name('cart.index');
Route::post('carrinho','SiteController@cart_add')->name('cart.add');
Route::post('remover-carrinho','SiteController@cart_remove')->name('cart.remove');
Route::get('limpar-carrinho','SiteController@cart_clear')->name('cart.clear');
Route::get('checkout/confirm', 'SiteController@checkout_confirm')->name('checkout.confirm');
Route::post('checkout/confirm', 'SiteController@checkout_post')->name('checkout.finalize');

Route::get('/downloadapolice', [SiteController::class, 'download_apolice'])->name('download_apolice');

Route::get('/planos', [SiteController::class, 'list_plans'])->name('planos');

Route::get('forget-password', 'Auth\ForgotPasswordController@getEmail');
Route::post('forget-password', 'Auth\ForgotPasswordController@postEmail');
