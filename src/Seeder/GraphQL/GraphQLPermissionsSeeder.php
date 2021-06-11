<?php

namespace Database\Seeders\Badaso\GraphQL;

use Illuminate\Database\Seeder;
use Uasoft\Badaso\Models\Permission;

class GraphQLPermissionsSeeder extends Seeder
{
    /**
     * Auto generated seed file.
     */
    public function run()
    {
        $keys = [
            'browse_graphql',
        ];

        foreach ($keys as $key) {
            Permission::firstOrCreate([
                'key' => $key,
                'table_name' => null,
                'description' => 'Browse GraphQL',
            ]);
        }
    }
}
