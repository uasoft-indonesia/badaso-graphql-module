---
sidebar_position: 3
---

# How Create New Mutation

1. create a new class file in `app\CustomizeBadasoGraphQL\ExampleMutationField::class`
```
<?php

namespace App\CustomizeBadasoGraphQL;

use GraphQL\Type\Definition\ResolveInfo;
use GraphQL\Type\Definition\Type;
use Uasoft\Badaso\Module\Graphql\Core\Abstracts\BaseFieldAbstract;

class ExampleMutationField extends BaseFieldAbstract
{
    public function getName(): string
    {
        // name query
        return 'exampleMutationField';
    }

    public function getType()
    {
        // get the previously registered example type
        return $this->generate_graphql->getCustomizeDataType('example_type');

        // or create new type
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
            'parameter1' => Type::string(),
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

    public function resolve($objectValue, $args, $context, ResolveInfo $info)
    {
        // show results
        return [
            'company_name' => 'Uasoft Indonesia ['.$args['parameter1'].']',
            'library_name' => 'Badaso',
            'module_name' => 'Badaso '.$args['parameter2']['module_name'],
        ];
    }
}
```
3. register class name in config `badaso-graphql-customize.php` on the `type` 
```
...
'mutation' => [
    ...
    App\CustomizeBadasoGraphQL\ExampleMutationField::class,
    ...
],
```