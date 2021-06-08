<?php

return [
    'graphql_prefix_route' => 'badaso/graphql',
    'middleware' => ['api', \Uasoft\Badaso\Middleware\BadasoAuthenticate::class],
    'class' => [
        'generate_graphql' => \Uasoft\Badaso\Module\Graphql\Core\GenerateGraphql::class,
        'generate_query_graphql' => \Uasoft\Badaso\Module\Graphql\Core\GenerateQueryGraphql::class,
        'generate_mutation_graphql' => \Uasoft\Badaso\Module\Graphql\Core\GenerateMutationGraphql::class,
    ],
    'accommodate_badaso_graphql_class' => App\BadasoGraphQL\AccommodateBadasoGraphQL::class,
];
