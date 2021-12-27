---
sidebar_position: 1
---

# How Create New Type

1. Buat file kelas baru di `app/CustomizeBadasoGraphql/Type/ExampleType.php`
```
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

```
2. Daftarkan nama kelas di config `badaso-graphql-customize.php` on the `type` 
```
...
'type' => [
    ...
    App\CustomizeBadasoGraphQL\Type\ExampleType::class,
    ...
],
...
```