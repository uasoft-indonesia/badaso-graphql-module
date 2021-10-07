# badaso/graphql-module

## How to installation graphql manager module
1. Install badaso graphql module

```
# For v1.x (laravel 5,6,7)
composer require badaso/graphql-module:^1.0

# For v2.x (laravel 8)
composer require badaso/graphql-module
```

3. Set env
```
MIX_DEFAULT_MENU=admin
MIX_BADASO_MENU=${MIX_DEFAULT_MENU},graphql-module
MIX_BADASO_MODULES=graphql-module

MIX_GRAPHQL_PREFIX_URI="/graphql-playground"
```
3. Call command `php artisan migrate`
4. Call command `php artisan badaso-graphql:setup`
5. Call command `composer dump-autoload`
7. Run database seeder

```
# For v1.x (laravel 5,6,7)
php artisan db:seed --class=BadasoGraphqlModuleSeeder

# For v2.x (laravel 8)
php artisan db:seed --class="Database\Seeders\Badaso\GraphQL\BadasoGraphqlModuleSeeder"
```

9. For test graphql, go to admin dashboard and menu item Graphql Playground

### Config badaso-graphql.php
```
return [
    'graphql_prefix_route' => 'badaso/graphql',
    // prefix graphql in http://host/badaso/graphql/v1
    // v1 is generate from route module
    'middleware' => ['api', \Uasoft\Badaso\Middleware\BadasoAuthenticate::class],
    // configure for middleware 
    'class' => [
        'generate_graphql' => \Uasoft\Badaso\Module\Graphql\Core\GenerateGraphql::class,
        // class generate query, mutation, and type
        'generate_query_graphql' => \Uasoft\Badaso\Module\Graphql\Core\GenerateQueryGraphql::class,
        // specific for generate read and browse
        // you can customize the class with extends this class and initial your new class to generate_query_graphql in config        
        'generate_mutation_graphql' => \Uasoft\Badaso\Module\Graphql\Core\GenerateMutationGraphql::class,
        // specific for generate create, update, and delete
        // you can customize the class with extends this class and initial your new class to generate_mutation_graphql in config  
    ],
];
