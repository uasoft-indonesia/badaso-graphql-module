<?php

namespace Uasoft\Badaso\Module\Graphql\Core\Query;

use stdClass;
use Uasoft\Badaso\Module\Graphql\Core\GenerateGraphql;
use Uasoft\Badaso\Module\Graphql\Interfaces\GenerateQueryInterface;

class MetaQuery implements GenerateQueryInterface
{
    public $graphql_data_type;

    public function setGenerateGraphQL(GenerateGraphql $generate_graphql, array $field_mutation): void
    {
        $this->graphql_data_type = $generate_graphql->graphql_data_type;
    }

    public function getFieldQuery(): array
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
