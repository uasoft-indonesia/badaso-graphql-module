---
sidebar_position: 5
---

# How Create Middleware
Anda dapat menambahkan middleware untuk permintaan graphql
```
class ExampleValidateMutationField extends BaseFieldAbstract
{   
    ...
    public function middlewareResolveHandle($objectValue, $args, $context, ResolveInfo $info)
    {
        ['whatCompanyName' => $what_company_name] = $args;

        if ($what_company_name == 'uasoft indonesia') {
            $random = rand(1, 9999);

            return [
                'company_name' => 'success[flag="'.Hash::make($random).'"]',
                'library_name' => 'success[flag="'.Hash::make($random).'"]',
                'module_name' => 'success[flag="'.Hash::make($random).'"]',
            ];
        }

        return $this->next($objectValue, $args, $context, $info);
    }
    ...
}
```