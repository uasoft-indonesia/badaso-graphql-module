<?php

namespace Uasoft\Badaso\Module\Graphql\Providers;

use Illuminate\Contracts\Http\Kernel;
use Illuminate\Foundation\AliasLoader;
use Illuminate\Support\ServiceProvider;
use Uasoft\Badaso\Module\Graphql\BadasoGraphqlModule;
use Uasoft\Badaso\Module\Graphql\Commands\BadasoGraphqlSetup;
use Uasoft\Badaso\Module\Graphql\Facades\BadasoGraphqlModule as FacadesBadasoGraphqlModule;
use Uasoft\Badaso\Module\Graphql\Middleware\BadasoGraphQLMiddleware;

class BadasoGraphqlModuleServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $kernel = $this->app->make(Kernel::class);
        $kernel->pushMiddleware(BadasoGraphQLMiddleware::class);

        $loader = AliasLoader::getInstance();
        $loader->alias('BadasoGraphqlModule', FacadesBadasoGraphqlModule::class);

        $this->app->singleton('badaso-graphql-module', function () {
            return new BadasoGraphqlModule();
        });

        $this->loadRoutesFrom(__DIR__.'/../Routes/graphql.php');

        $this->publishes([
            __DIR__ . '/../CustomizeBadasoGraphQL' => app_path('CustomizeBadasoGraphQL'),
        ], 'badaso-graphql');

        $this->publishes([
            __DIR__.'/../Config/badaso-graphql.php' => config_path('badaso-graphql.php'),
            __DIR__.'/../Config/badaso-graphql-customize.php' => config_path('badaso-graphql-customize.php'),
            __DIR__.'/../Config/graphql-playground.php' => config_path('graphql-playground.php'),
        ], 'badaso-graphql-config');

        $this->publishes([
            __DIR__.'/../Seeder' => database_path('seeders/Badaso'),
        ], 'badaso-graphql-seeder');
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
        $this->commands(BadasoGraphqlSetup::class);
    }
}
