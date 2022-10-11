<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Services\Integration\ClientSenderIntegrationService;
use App\Services\Integration\IClientSenderIntegrationService;
use App\Services\Integration\IntegrationConfigService;
use App\Services\Integration\IIntegrationConfigService;
use App\Services\IPlanoDBService;
use App\Services\PlanoDBService;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
        $this->app->bind(IIntegrationConfigService::class, IntegrationConfigService::class);
        $this->app->bind(IClientSenderIntegrationService::class, ClientSenderIntegrationService::class);
        $this->app->bind(IPlanoDBService::class, PlanoDBService::class);
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
