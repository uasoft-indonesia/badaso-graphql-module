<?php

namespace Uasoft\Badaso\Module\Graphql\Providers;

use Illuminate\Foundation\AliasLoader;
use Illuminate\Routing\Router;
use Illuminate\Support\ServiceProvider;
use Uasoft\Badaso\Module\Graphql\BadasoGraphqlModule;
use Uasoft\Badaso\Module\Graphql\Facades\BadasoGraphqlModule as FacadesBadasoGraphqlModule;

class BadasoGraphqlModuleServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $loader = AliasLoader::getInstance();
        $loader->alias('BadasoGraphqlModule', FacadesBadasoGraphqlModule::class);

        $router = $this->app->make(Router::class);

        $this->app->singleton('badaso-graphql-module', function () {
            return new BadasoGraphqlModule();
        });

        $this->loadRoutesFrom(__DIR__.'/../Routes/web.php');

        $this->publishes([
            __DIR__.'/../Config/badaso-graphql.php' => config_path('badaso-graphql.php'),
        ], 'badaso-graphql-config');
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->registerConsoleCommands();
    }

    /**
     * Register the commands accessible from the Console.
     */
    private function registerConsoleCommands()
    {
        // $this->commands(BadasoGraphqlSetup::class);
    }
}
