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
