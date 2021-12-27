---
sidebar_position: 2
---

# Configuration

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