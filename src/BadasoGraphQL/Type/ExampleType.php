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
