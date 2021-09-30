<?php

namespace Uasoft\Badaso\Module\Graphql\Core\Type;

use GraphQL\Type\Definition\ObjectType;
use GraphQL\Type\Definition\Type;
use Uasoft\Badaso\Helpers\CaseConvert;

class PaginateType extends ObjectType
{
    public function __construct(ObjectType $dataType, string $key)
    {
        parent::__construct([
            'name' => CaseConvert::camel('pagination_'.$key),
            'fields' => [
                'data' => [
                    'type' => Type::listOf($dataType),
                ],
                'maxData' => [
                    'type' => Type::int(),
                ],
                'maxPage' => [
                    'type' => Type::int(),
                ],
            ],
        ]);
    }

    public static function result($data, $max_data, $max_page): array
    {
        return [
            'data' => $data,
            'maxData' => $max_data,
            'maxPage' => $max_page,
        ];
    }
}
