<?php

namespace App\CustomizeBadasoGraphQL;

use GraphQL\Type\Definition\ResolveInfo;
use GraphQL\Type\Definition\Type;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Uasoft\Badaso\Module\Graphql\Core\Abstracts\BaseFieldAbstract;
use Uasoft\Badaso\Module\Graphql\Core\Exception\BadasoGraphQLException;

class ExampleValidateMutationField extends BaseFieldAbstract
{
    public function getName(): string
    {
        return 'exampleValidateMutationField';
    }

    public function getType()
    {
        return $this->generate_graphql->getCustomizeDataType('example_type');
    }

    public function getArgs(): array
    {
        return [
            'whatCompanyName' => [
                'type' => Type::string(),
            ],
            'whatLibraryName' => [
                'type' => Type::string(),
            ],
            'whatModuleName' => [
                'type' => Type::string(),
            ],
        ];
    }

    public function resolve($objectValue, $args, $context, ResolveInfo $info)
    {
        $validate = Validator::make($args, [
            'whatCompanyName' => ['required', function ($att, $value, $fail) {
                if (strtolower($value) != 'uasoft') {
                    return $fail('Incorrect answer company name');
                }
            }],
            'whatLibraryName' => ['required', function ($att, $value, $fail) {
                if (strtolower($value) != 'badaso') {
                    return $fail('Incorrect answer library name');
                }
            }],
            'whatModuleName' => ['required', function ($att, $value, $fail) {
                if (strtolower($value) != 'graphql') {
                    return $fail('Incorrect answer library name');
                }
            }],
        ]);

        if ($validate->fails()) {
            throw new BadasoGraphQLException('Invalidate Parameter', $validate->errors()->toArray());
        }

        return [
            'company_name' => 'Uasoft Indonesia',
            'library_name' => 'Badaso',
            'module_name' => 'Badaso GraphGL',
        ];
    }

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
}
