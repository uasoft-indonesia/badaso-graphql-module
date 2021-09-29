<?php

namespace App\CustomizeBadasoGraphQL\Type;

use GraphQL\Type\Definition\InputObjectType;
use GraphQL\Type\Definition\Type;

class ExampleInputType extends InputObjectType
{
    public function __construct()
    {
        parent::__construct([
            'name' => 'example_input_type',
            'fields' => [
                'module_name' => [
                    'type' => Type::nonNull(Type::string()),
                ]
            ]
        ]);
    }
}
