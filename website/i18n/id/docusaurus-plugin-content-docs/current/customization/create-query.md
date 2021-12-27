---
sidebar_position: 2
---

# How Create New Query

1. Buat file kelas baru di `app/CustomizeBadasoGraphQL/ExampleQueryField::class`
```
<?php

namespace App\CustomizeBadasoGraphQL;

use GraphQL\Type\Definition\ResolveInfo;
use GraphQL\Type\Definition\Type;
use Uasoft\Badaso\Module\Graphql\Core\Abstracts\BaseFieldAbstract;

class ExampleQueryField extends BaseFieldAbstract
{
    public function getName(): string
    {
        // name query
        return 'exampleFieldQuery';
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
        // parsing parameter for query
        return [
            'parameter1' => Type::nonNull(Type::string()),
        ];
    }

    public function resolve($objectValue, $args, $context, ResolveInfo $info)
    {
        // show results
        return [
            'company_name' => 'Uasoft Indonesia',
            'library_name' => 'Badaso',
            'module_name' => 'Badaso GraphGL',
        ];
    }
}
```
2. Daftarkan nama kelas di config `badaso-graphql-customize.php` on the `type` 
```
...
'query' => [
    ...
    App\CustomizeBadasoGraphQL\ExampleQueryField::class,
    ...
],
...
```