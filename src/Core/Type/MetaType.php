<?php

namespace Uasoft\Badaso\Module\Graphql\Core\Type;

use GraphQL\Type\Definition\ObjectType;
use GraphQL\Type\Definition\Type;
use Illuminate\Support\Facades\Storage;
use Uasoft\Badaso\Module\Graphql\Core\GenerateGraphql;
use Uasoft\Badaso\Module\Graphql\Interfaces\GenerateTypeInterface;

class MetaType implements GenerateTypeInterface
{
    public function setGenerateGraphQL(GenerateGraphql $generate_graphql): void
    {
    }

    public function getType(): array
    {
        return [
            'meta' => new ObjectType([
                'name' => 'Meta',
                'fields' => [
                    'media_base_url' => [
                        'type' => Type::string(),
                        'resolve' => function ($rootValue, $args) {
                            return Storage::url('/');
                        },
                    ],
                ],
            ]),
        ];
    }
}
