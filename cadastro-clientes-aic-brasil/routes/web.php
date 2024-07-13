<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\SiteController;

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

Route::get('/', "SiteController@home")->name('index');

Route::prefix("admin")->middleware('auth')->group(function(){
    Route::get('', function () {
        return redirect('/admin/clients');
    });
    Route::get('/clients', [AdminController::class, 'clients'])->name('client.list');
    Route::get('/clients/{id}', [AdminController::class, 'clientById'])->name('client.detail');
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
    Route::post('/afiliados/novo', [AdminController::class, 'novoAfiliado'])->name('afiliados.novo');
    Route::post('/afiliados/novo-codigo', [AdminController::class, 'novoCodigoAfiliado'])->name('afiliados.novoCodigo');
    Route::post('/afiliados/remover', [AdminController::class, 'removerAfiliado'])->name('afiliados.remover');
    Route::get('/pacotes', [AdminController::class, 'pacotes'])->name('pacotes.list');
    Route::get('/pacotes/{id}', [AdminController::class, 'pacotesById'])->name('pacotes.detail');
    Route::get('/afiliados', [AdminController::class, 'afiliados'])->name('afiliados.list');
    Route::post('/afiliados/novo', [AdminController::class, 'novoAfiliado'])->name('afiliados.novo');
    Route::post('/afiliados/novo-codigo', [AdminController::class, 'novoCodigoAfiliado'])->name('afiliados.novoCodigo');
    Route::post('/afiliados/remover', [AdminController::class, 'removerAfiliado'])->name('afiliados.remover');
    Route::get('/visita-imovel', [AdminController::class, 'visitas'])->name('visitas');
    Route::get('/listar-visitas', [AdminController::class, 'listarVisitas'])->name('listar.visita');
    Route::post('/visita-imovel', [AdminController::class, 'criarVisita'])->name('visita.criar');
    Route::post('/visita-imovel/{id}', [AdminController::class, 'editarVisita'])->name('visita.editar');
    Route::get('/listar-imoveis', [AdminController::class, 'listarImoveis'])->name('listar.imoveis');
    Route::get('/obter-imovel/{id}', [AdminController::class, 'obterImovel'])->name('obter.imovel');
    Route::post('/imovel', [AdminController::class, 'criarImovel'])->name('imovel.criar');
    Route::post('/imovel/{id}', [AdminController::class, 'editarImovel'])->name('imovel.editar');
    Route::delete('/imovel/remover', [AdminController::class, 'removerImovel']);
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
Route::get('/comprar-plano/{id_plano}', [SiteController::class, 'comprar_plano'])->name('site.comprar_plano');
Route::get('/vieworder', [SiteController::class, 'view_pacote'])->name('view.order');
Route::post('/vieworder', [SiteController::class, 'view_order_post'])->name('view.order.post');

Route::get('/pdf/{ordercode}/{sendEmail?}', 'HomeController@pdf');
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
Route::get('carrinho','SiteController@cart')->name('cart.index');
Route::post('carrinho','SiteController@cart_add')->name('cart.add');
Route::post('remover-carrinho','SiteController@cart_remove')->name('cart.remove');
Route::get('limpar-carrinho','SiteController@cart_clear')->name('cart.clear');
Route::get('checkout/confirm', 'SiteController@checkout_confirm')->name('checkout.confirm');
Route::post('checkout/confirm', 'SiteController@checkout_post')->name('checkout.finalize');
Route::get('bank/create-account/{type}', 'SiteController@createBankAccount')->name('create.bank.account');
Route::post('bank/create-account/{type}', 'SiteController@createBankAccountPost')->name('create.bank.account.post');
Route::get('bank/mandatory-documents/{type}', 'SiteController@formMandatoryDocuments')->name('mandatory.documents');
Route::post('bank/mandatory-documents/{type}', 'SiteController@formMandatoryDocumentsPost')->name('mandatory.documents.post');

Route::get('forget-password', 'Auth\ForgotPasswordController@getEmail');
Route::post('forget-password', 'Auth\ForgotPasswordController@postEmail');

Route::get('bank/created', 'SiteController@bankCreated')->name('bank.created');

Route::get('/cep/{cep}', "CepController@getCepData");

if (app()->environment('development')) {
    Route::get('test/email/{id}', 'SiteController@test_email')->name('test.email');
}

