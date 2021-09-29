<?php
namespace Uasoft\Badaso\Module\Graphql\Core\Type;

use GraphQL\Type\Definition\ObjectType;
use GraphQL\Type\Definition\Type;

class PaginateType extends ObjectType
{
    public function __construct(ObjectType $dataType)
    {
        parent::__construct([
            'name' => 'pagination',
            'fields' => [
                'data' => [
                    'type' => Type::listOf($dataType),
                ],
                'current_page' => [
                    'type' => Type::int(),
                ],
                'first_page_url' => [
                    'type' => Type::string(),
                ],
                'from' => [
                    'type' => Type::int(),
                ],
                'next_page_url' => [
                    'type' => Type::string(),
                ],
                'path' => [
                    'type' => Type::string(),
                ],
                'per_page' => [
                    'type' => Type::int(),
                ],
                'prev_page_url' => [
                    'type' => Type::string(),
                ],
                'to' => [
                    'type' => Type::int(),
                ],
            ]
        ]);
    }
}
