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
MIX_BADASO_PLUGINS=graphql-module

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

### Configuration  

1. badaso-graphql.php

if you want to change default route and default middleware of qraphql-module you can change this file
```
<?php

return [
    'graphql_prefix_route' => 'badaso/graphql', 
    'middleware' => [\Uasoft\Badaso\Module\Graphql\Middleware\BadasoGraphQLMiddleware::class],
];
```
  - `graphql_prefix_route` is default route `badaso/graphql`
  - `middleware` is default middleware use class `\Uasoft\Badaso\Module\Graphql\Middleware\BadasoGraphQLMiddleware::class`

2. badaso-graphql-customize.php

if you want to make changes or additions to the data type, query, and mutation you can edit this file
```
return [
    'core' => [
        'generate_graphql' => \Uasoft\Badaso\Module\Graphql\Core\GenerateGraphql::class,
        'generate_query_graphql' => \Uasoft\Badaso\Module\Graphql\Core\GenerateQueryGraphql::class,
        'generate_mutation_graphql' => \Uasoft\Badaso\Module\Graphql\Core\GenerateMutationGraphql::class,
    ],

    'type' => [
        App\CustomizeBadasoGraphQL\Type\ExampleType::class,
        App\CustomizeBadasoGraphQL\Type\ExampleInputType::class,
        // register type ...
    ],

    'query' => [
        App\CustomizeBadasoGraphQL\ExampleQueryField::class,
        // register query ...
    ],

    'mutation' => [
        App\CustomizeBadasoGraphQL\ExampleMutationField::class,
        App\CustomizeBadasoGraphQL\ExampleValidateMutationField::class,
        // register mutation ...
    ],
];
```
 - `core` is default generate type, query, and mutation table crud generate
 - `type` is the place to register your new graphqhl type
 - `query` is the place to register your new graphql query
 - `mutation` is the place to register your new graphql mutation

### How Create New Type
1. create a new class file in `app/CustomizeBadasoGraphql/Type/ExampleType.php`
```
<?php

namespace App\CustomizeBadasoGraphQL\Type;

use GraphQL\Type\Definition\ObjectType;
use GraphQL\Type\Definition\Type;

class ExampleType extends ObjectType
{
    public function __construct()
    {
        parent::__construct([
            'name' => 'example_type',
            'fields' => [
                'company_name' => [
                    'type' => Type::string(),
                ],
                'library_name' => [
                    'type' => Type::string(),
                ],
                'module_name' => [
                    'type' => Type::string(),
                ],
            ],
        ]);
    }
}

```
2. register class name in config `badaso-graphql-customize.php` on the `type` 
```
...
'type' => [
    ...
    App\CustomizeBadasoGraphQL\Type\ExampleType::class,
    ...
],
...
```

### How Create New Query
1. create a new class file in `app/CustomizeBadasoGraphQL/ExampleQueryField::class`
```
<?php

namespace App\CustomizeBadasoGraphQL;

use GraphQL\Type\Definition\ResolveInfo;
use GraphQL\Type\Definition\Type;
use Uasoft\Badaso\Module\Graphql\Core\Abstracts\BaseFieldAbstract;

class ExampleQueryField extends BaseFieldAbstract
{
    public function getName(): string
    {
        // name query
        return 'exampleFieldQuery';
    }

    public function getType()
    {
        // get the previously registered example type
        return $this->generate_graphql->getCustomizeDataType('example_type');

        // or create new type
        // return new \GraphQL\Type\Definition\ObjectType([
        //     'name' => 'example_type',
        //     'fields' => [
        //         'company_name' => [
        //             'type' => \GraphQL\Type\Definition\Type::string(),
        //         ],
        //         'library_name' => [
        //             'type' => \GraphQL\Type\Definition\Type::string(),
        //         ],
        //         'module_name' => [
        //             'type' => \GraphQL\Type\Definition\Type::string(),
        //         ]
        //     ]
        // ]);
    }

    public function getArgs(): array
    {
        // parsing parameter for query
        return [
            'parameter1' => Type::nonNull(Type::string()),
        ];
    }

    public function resolve($objectValue, $args, $context, ResolveInfo $info)
    {
        // show results
        return [
            'company_name' => 'Uasoft Indonesia',
            'library_name' => 'Badaso',
            'module_name' => 'Badaso GraphGL',
        ];
    }
}
```
2. register class name in config `badaso-graphql-customize.php` on the `type` 
```
...
'query' => [
    ...
    App\CustomizeBadasoGraphQL\ExampleQueryField::class,
    ...
],
...
```

### How Create New Mutation
1. create a new class file in `app\CustomizeBadasoGraphQL\ExampleMutationField::class`
```
<?php

namespace App\CustomizeBadasoGraphQL;

use GraphQL\Type\Definition\ResolveInfo;
use GraphQL\Type\Definition\Type;
use Uasoft\Badaso\Module\Graphql\Core\Abstracts\BaseFieldAbstract;

class ExampleMutationField extends BaseFieldAbstract
{
    public function getName(): string
    {
        // name query
        return 'exampleMutationField';
    }

    public function getType()
    {
        // get the previously registered example type
        return $this->generate_graphql->getCustomizeDataType('example_type');

        // or create new type
        // return new \GraphQL\Type\Definition\ObjectType([
        //     'name' => 'example_type',
        //     'fields' => [
        //         'company_name' => [
        //             'type' => \GraphQL\Type\Definition\Type::string(),
        //         ],
        //         'library_name' => [
        //             'type' => \GraphQL\Type\Definition\Type::string(),
        //         ],
        //         'module_name' => [
        //             'type' => \GraphQL\Type\Definition\Type::string(),
        //         ]
        //     ]
        // ]);
    }

    public function getArgs(): array
    {
        return [
            'parameter1' => Type::string(),
            'parameter2' => $this->generate_graphql->getCustomizeDataType('example_input_type'),

            // or
            // 'parameter2' => new \GraphQL\Type\Definition\InputObjectType([
            //     'name' => 'example_input_type',
            //     'fields' => [
            //         'module_name' => [
            //             'type' => \GraphQL\Type\Definition\Type::string(),
            //         ]
            //     ]
            // ])
        ];
    }

    public function resolve($objectValue, $args, $context, ResolveInfo $info)
    {
        // show results
        return [
            'company_name' => 'Uasoft Indonesia ['.$args['parameter1'].']',
            'library_name' => 'Badaso',
            'module_name' => 'Badaso '.$args['parameter2']['module_name'],
        ];
    }
}
```
3. register class name in config `badaso-graphql-customize.php` on the `type` 
```
...
'mutation' => [
    ...
    App\CustomizeBadasoGraphQL\ExampleMutationField::class,
    ...
],
```

### How Create Validation For Query and Mutation Type

You can add validation to input on query or mutation
```
class ExampleValidateMutationField extends BaseFieldAbstract
{   
    ...
    public function resolve($objectValue, $args, $context, ResolveInfo $info)
    {
        $validate = Validator::make($args, [
            'whatCompanyName' => ['required', function ($att, $value, $fail) {
                if (strtolower($value) != 'uasoft') {
                    return $fail('Incorrect answer company name');
                }
            }],
            'whatLibraryName' => ['required', function ($att, $value, $fail) {
                if (strtolower($value) != 'badaso') {
                    return $fail('Incorrect answer library name');
                }
            }],
            'whatModuleName' => ['required', function ($att, $value, $fail) {
                if (strtolower($value) != 'graphql') {
                    return $fail('Incorrect answer library name');
                }
            }],
        ]);

        if ($validate->fails()) {
            throw new BadasoGraphQLException('Invalidate Parameter', $validate->errors()->toArray());
        }

        return [
            'company_name' => 'Uasoft Indonesia',
            'library_name' => 'Badaso',
            'module_name' => 'Badaso GraphGL',
        ];
    }
    ...
}
```
You can use `BadasoGraphQLException` class to give error response

### How Create Middleware Resolve 
You can add middleware for graphql requests
```
class ExampleValidateMutationField extends BaseFieldAbstract
{   
    ...
    public function middlewareResolveHandle($objectValue, $args, $context, ResolveInfo $info)
    {
        ['whatCompanyName' => $what_company_name] = $args;

        if ($what_company_name == 'uasoft indonesia') {
            $random = rand(1, 9999);

            return [
                'company_name' => 'success[flag="'.Hash::make($random).'"]',
                'library_name' => 'success[flag="'.Hash::make($random).'"]',
                'module_name' => 'success[flag="'.Hash::make($random).'"]',
            ];
        }

        return $this->next($objectValue, $args, $context, $info);
    }
    ...
}
```

   
