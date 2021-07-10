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
    'accommodate_badaso_graphql_class' => App\BadasoGraphQL\AccommodateBadasoGraphQL::class,
    // this class is core customize query, mutation, and type
    // you can customize the class with extends this class and initial your new class to accommodate_badaso_graphql_class in config  
];

```
### How Create New Query  
1. Create new class in `App/BadasoGraphQL/Query`
2. Implements from new class with ` Uasoft\Badaso\Module\Graphql\Interfaces\GenerateQueryInterface` 
3. There are two method must be created
```
public function setGenerateGraphQL(GenerateGraphql $generate_graphql, array $field_mutation): void
{
    ...
}

public function getFieldQuery(): array
{
    return [
        "{nameQuery}" => [
            "type" => {Type},
            "args" => [
                "{params}" => {Type}
            ],
            "resolve" => function($rootValue, $args): {Type}{
                return {ObjectType}
            }
        ]
    ]
}
```
4. For full example class 
```
<?php

namespace App\BadasoGraphQL\Query;

use GraphQL\Type\Definition\Type;
use Uasoft\Badaso\Module\Graphql\Core\GenerateGraphql;
use Uasoft\Badaso\Module\Graphql\Interfaces\GenerateQueryInterface;

class ExampleQuery implements GenerateQueryInterface
{
    public $generate_graphql;
    public $field_mutation;

    public function setGenerateGraphQL(GenerateGraphql $generate_graphql, array $field_mutation): void
    {
        $this->generate_graphql = $generate_graphql;
        $this->field_mutation = $field_mutation;
    }

    public function getFieldQuery(): array
    {
        return [
            'exampleQuery' => [
                'type' => Type::string(),
                'args' => [
                    'example_param' => Type::string(),
                ],
                'resolve' => function ($rootValue, $args) {
                    return json_encode($args);
                },
            ],
        ];
    }
}
```
5. For `getFieldQuery()` for result array, you can customize according to the following [graphql-php/schema-definition](https://webonyx.github.io/graphql-php/schema-definition/ ) only in the query fields element array 

### How create new mutation
1. Create new class in `App/BadasoGraphQL/Mutation`
2. Implements from new class with ` Uasoft\Badaso\Module\Graphql\Interfaces\GenerateMutationInterface` 
3. There are two method must be created
```
public function setGenerateGraphQL(GenerateGraphql $generate_graphql, array $field_mutation): void
{
    ...
}

public function getFieldMutation(): array
{
    return [
        "{nameMutation}" => [
            "type" => {Type},
            "args" => [
                "{params}" => {Type}
            ],
            "resolve" => function($rootValue, $args): {Type}{
                return {ObjectType}
            }
        ]
    ]
}
```
4. For full example class 
```
<?php

namespace App\BadasoGraphQL\Mutation;

use GraphQL\Type\Definition\Type;
use Uasoft\Badaso\Module\Graphql\Core\GenerateGraphql;
use Uasoft\Badaso\Module\Graphql\Interfaces\GenerateMutationInterface;

class ExampleMutation implements GenerateMutationInterface
{
    public $generate_graphql;
    public $field_mutation;

    public function setGenerateGraphQL(GenerateGraphql $generate_graphql, array $field_mutation): void
    {
        $this->generate_graphql = $generate_graphql;
        $this->field_mutation = $field_mutation;
    }

    public function getFieldMutation(): array
    {
        return [
            'exampleMutation' => [
                'type' => Type::string(),
                'args' => [
                    'example_param' => Type::string(),
                ],
                'resolve' => function ($rootValue, $args) {
                    return json_encode($args);
                },
            ],
        ];
    }
}

```
5. For `getFieldMutation()` for result array, you can customize according to the following [graphql-php/schema-definition](https://webonyx.github.io/graphql-php/schema-definition/ ) only in the mutation fields element array 

### How create new type  
1. Create new class in `App/BadasoGraphQL/Type`
2. Implements from new class with ` Uasoft\Badaso\Module\Graphql\Interfaces\GenerateTypeInterface` 
3. There are two method must be created
```
public function setGenerateGraphQL(GenerateGraphql $generate_graphql, array $field_mutation): void
{
    ...
}

public function getType(): array
{
    return [
        "{nameType}" => new ObjectType([
            'name' => "{nameType}",
            'fields' => [
                '{attribute_n1}' => [
                    'type' => {Type},
                ],
                '{attribute_n2}' => [
                    'type' => {Type},
                ],
                ...
            ],
        ]),
    ];
}
```
4. For full example class 
```
<?php

namespace App\BadasoGraphQL\Type;

use GraphQL\Type\Definition\ObjectType;
use GraphQL\Type\Definition\Type;
use Uasoft\Badaso\Module\Graphql\Core\GenerateGraphql;
use Uasoft\Badaso\Module\Graphql\Interfaces\GenerateTypeInterface;

class ExampleType implements GenerateTypeInterface
{
    public $generate_graphql;

    public function setGenerateGraphQL(GenerateGraphql $generate_graphql): void
    {
        $this->generate_graphql = $generate_graphql;
    }

    public function getType(): array
    {
        return [
            'exampleType' => new ObjectType([
                'name' => 'exampleType',
                'fields' => [
                    'example' => [
                        'type' => Type::string(),
                    ],
                ],
            ]),
        ];
    }
}

```
5. For `getType()` for result array, you can customize according to the following [graphql-php/type-definitions](https://webonyx.github.io/graphql-php/type-definitions/) only in the mutation fields element array 


### Advanced Understanding 
For further understanding, you can study [graphql-php](https://webonyx.github.io/graphql-php/getting-started/)
