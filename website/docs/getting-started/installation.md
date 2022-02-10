---
sidebar_position: 1
---

# Installation

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