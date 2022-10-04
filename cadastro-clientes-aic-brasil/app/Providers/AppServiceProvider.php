<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Services\ClientIntegrationService;
use App\Services\IClientIntegrationService;
use App\Services\Integration\IntegrationService;
use App\Services\Integration\IIntegrationService;

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
