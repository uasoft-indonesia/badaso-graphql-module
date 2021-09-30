<?php

namespace App\CustomizeBadasoGraphQL;

use Uasoft\Badaso\Module\Graphql\Core\Abstracts\BaseFieldAbstract;

class ExampleMutationField extends BaseFieldAbstract
{
    public function getName(): string
    {
        return 'exampleMutationField';
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
            'parameter1' => \GraphQL\Type\Definition\Type::string(),
            'parameter2' => $this->generate_graphql->getCustomizeDataType('example_input_type'),

            // or
            // 'parameter2' => new \GraphQL\Type\Definition\InputObjectType([
            //     'name' => 'example_input_type',
            //     'fields' => [
            //         'module_name' => [
            //             'type' => \GraphQL\Type\Definition\Type::string(),
            //         ]
            //     ]
            // ])
        ];
    }

    public function resolve($objectValue, $args, $context, \GraphQL\Type\Definition\ResolveInfo $info)
    {
        return [
            'company_name' => 'Uasoft Indonesia ['.$args['parameter1'].']',
            'library_name' => 'Badaso',
            'module_name' => 'Badaso '.$args['parameter2']['module_name'],
        ];
    }
}
