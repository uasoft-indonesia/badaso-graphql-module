<?php

namespace App\CustomizeBadasoGraphQL\Type;

use GraphQL\Type\Definition\ObjectType;
use GraphQL\Type\Definition\Type;

class ExampleType extends ObjectType
{
    public function __construct()
    {
        parent::__construct([
            'name' => 'example_type',
            'fields' => [
                'company_name' => [
                    'type' => Type::string(),
                ],
                'library_name' => [
                    'type' => Type::string(),
                ],
                'module_name' => [
                    'type' => Type::string(),
                ],
            ],
        ]);
    }
}
