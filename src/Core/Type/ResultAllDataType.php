<?php

namespace Uasoft\Badaso\Module\Graphql\Core\Type;

use GraphQL\Type\Definition\ObjectType;
use GraphQL\Type\Definition\Type;
use Uasoft\Badaso\Helpers\CaseConvert;

class ResultAllDataType extends ObjectType
{
    public function __construct(ObjectType $dataType, string $key)
    {
        parent::__construct([
            'name' =>  CaseConvert::camel('result_all_data_'.$key),
            'fields' => [
                'data' => Type::listOf($dataType),
                'maxData' => [
                    'type' => Type::int(),
                ],
            ],
        ]);
    }

    public static function result($data, $max_data)
    {
        return [
            'data' => $data,
            'maxData' => $max_data,
        ];
    }
}
