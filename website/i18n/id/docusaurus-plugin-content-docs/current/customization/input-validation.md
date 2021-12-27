---
sidebar_position: 4
---


# How Create Validation For Query and Mutation Type

Anda dapat menambahkan validasi ke input pada kueri atau mutasi
```
class ExampleValidateMutationField extends BaseFieldAbstract
{   
    ...
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
    ...
}
```
Anda dapat menggunakan kelas `BadasoGraphQLException` untuk memberikan respons kesalahan