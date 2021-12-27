---
sidebar_position: 2
---

# Configuration

1. badaso-graphql.php

jika Anda ingin mengubah rute default dan middleware default modul qraphql, Anda dapat mengubah file ini
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

jika anda ingin melakukan perubahan atau penambahan pada tipe data, query, dan mutasi anda dapat mengedit file ini
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
 - `core` adalah default generate type, query, dan tabel mutasi crud generate
 - `type` adalah tempat untuk mendaftarkan jenis graphqhl baru Anda
 - `query` adalah tempat untuk mendaftarkan kueri graphql baru Anda
 - `mutation` adalah tempat untuk mendaftarkan mutasi graphql baru Anda