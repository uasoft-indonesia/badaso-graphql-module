<?php

namespace App\CustomizeBadasoGraphQL;

use GraphQL\Type\Definition\Type;
use Uasoft\Badaso\Module\Graphql\Core\Abstracts\BaseFieldAbstract;

class ExampleQueryField extends BaseFieldAbstract {

    public function getName(): string
    {
        return "exampleFieldQuery";
    }

    public function getType()
    {
        return $this->generate_graphql->getCustomizeDataType('example_type');

        // or
        // return new \GraphQL\Type\Definition\ObjectType([
        //     'name' => 'example_type',
        //     'fields' => [
        //         'company_name' => [
        //             'type' => \GraphQL\Type\Definition\Type::string(),
        //         ],
        //         'library_name' => [
        //             'type' => \GraphQL\Type\Definition\Type::string(),
        //         ],
        //         'module_name' => [
        //             'type' => \GraphQL\Type\Definition\Type::string(),
        //         ]
        //     ]
        // ]);
    }

    public function getArgs(): array
    {
        return [
            'parameter1' => Type::nonNull(\GraphQL\Type\Definition\Type::string()),
        ];
    }

    public function resolve($objectValue, $args, $context, \GraphQL\Type\Definition\ResolveInfo $info)
    {
        return [
            'company_name' => 'Uasoft Indonesia',
            'library_name' => 'Badaso',
            'module_name' => 'Badaso GraphGL'
        ];
    }
}
