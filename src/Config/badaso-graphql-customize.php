<?php

use GraphQL\Type\Definition\InputObjectType;
use GraphQL\Type\Definition\ObjectType;
use GraphQL\Type\Definition\Type;

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
        // register mutation ...
    ],
];
