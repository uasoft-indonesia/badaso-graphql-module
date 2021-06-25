<?php

namespace Uasoft\Badaso\Module\Graphql\Core\Mutation;

use stdClass;
use Uasoft\Badaso\Module\Graphql\Core\GenerateGraphql;
use Uasoft\Badaso\Module\Graphql\Interfaces\GenerateMutationInterface;

class MetaMutation implements GenerateMutationInterface
{
    public $generate_graphql;
    public $field_mutation;
    public $graphql_data_type;

    public function setGenerateGraphQL(GenerateGraphql $generate_graphql, array $field_mutation): void
    {
        $this->generate_graphql = $generate_graphql;
        $this->field_mutation = $field_mutation;
        $this->graphql_data_type = $generate_graphql->graphql_data_type;
    }

    public function getFieldMutation(): array
    {
        return [
            'meta' => [
                'type' => $this->graphql_data_type['meta'],
                'resolve' => function ($rootValue, $args) {
                    return new stdClass();
                },
            ],
        ];
    }
}
