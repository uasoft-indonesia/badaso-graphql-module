<?php

namespace Uasoft\Badaso\Module\Graphql\Providers;

use GraphQL\Language\Parser;
use Illuminate\Contracts\Http\Kernel;
use Illuminate\Foundation\AliasLoader;
use Illuminate\Support\ServiceProvider;
use Nuwave\Lighthouse\Schema\TypeRegistry;
use Uasoft\Badaso\Module\Graphql\BadasoGraphqlModule;
use Uasoft\Badaso\Module\Graphql\Core\GenerateTypeGraphql;
use Uasoft\Badaso\Module\Graphql\Facades\BadasoGraphqlModule as FacadesBadasoGraphqlModule;
use Uasoft\Badaso\Module\Graphql\Middleware\BadasoGraphQLMiddleware;

class BadasoGraphqlModuleServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot(TypeRegistry $typeRegistry)
    {
        $kernel = $this->app->make(Kernel::class);
        $kernel->pushMiddleware(BadasoGraphQLMiddleware::class);

        $loader = AliasLoader::getInstance();
        $loader->alias('BadasoGraphqlModule', FacadesBadasoGraphqlModule::class);

        $this->app->singleton('badaso-graphql-module', function () {
            return new BadasoGraphqlModule();
        });

        $this->publishes([
            // __DIR__.'/../Config/badaso-graphql.php' => config_path('badaso-graphql.php'),
        ], 'badaso-graphql-config');

        $contents = file_get_contents(base_path('graphql/schema.graphql'));
        $schema = Parser::parse($contents);

        $generateDataType = new GenerateTypeGraphql($typeRegistry);
        $generateDataType->handle();
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
