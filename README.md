# badaso-graphql-module

## How to installation graphql manager module
1. <a href="https://badaso-docs.uatech.co.id/docs/en/getting-started/installation/" target="blank"> Install Badaso </a> from laravel project
2. Install badaso graphql module `composer require uasoft-indonesia/badaso-graphql-module` 
3. Set env
```
MIX_DEFAULT_MENU=admin
MIX_BADASO_MENU=${MIX_DEFAULT_MENU},badaso-graphql-module
MIX_BADASO_MODULES=badaso-graphql-module

MIX_GRAPHQL_PREFIX_URI="/graphql-playground"
```
3. Call command `php artisan migrate`
4. Call command `php artisan badaso-graphql:setup` or `php artisan badaso-graphql:setup --force` if you want to overwrite the file 
5. Call command `composer dump-autoload`
6. Call command `php artisan db:seed --class=GraphqlModuleSeeder`

### Config badaso-graphql.php
```
return [
    'graphql_prefix_route' => 'badaso/graphql',
    'middleware' => ['api', \Uasoft\Badaso\Middleware\BadasoAuthenticate::class],
    // configure for middleware 
    'class' => [
        'generate_graphql' => \Uasoft\Badaso\Module\Graphql\Core\GenerateGraphql::class,
        'generate_query_graphql' => \Uasoft\Badaso\Module\Graphql\Core\GenerateQueryGraphql::class,
        'generate_mutation_graphql' => \Uasoft\Badaso\Module\Graphql\Core\GenerateMutationGraphql::class,
    ],
    'accommodate_badaso_graphql_class' => App\BadasoGraphQL\AccommodateBadasoGraphQL::class,
];

```

### How customize Query  

### How customize Mutation

### How customize Type  

