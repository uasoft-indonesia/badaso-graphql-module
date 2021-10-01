<?php

namespace Database\Seeders\Badaso\GraphQL;

use Illuminate\Database\Seeder;
use Uasoft\Badaso\Models\Menu;

class BadasoGraphQLMenusSeeder extends Seeder
{
    /**
     * Auto generated seed file.
     *
     * @return void
     *
     * @throws Exception
     */
    public function run()
    {
        \DB::beginTransaction();

        try {
            $new_menus = [
                'key' => 'graphql-module',
                'display_name' => 'GraphQL Menu',
                'created_at' => '2021-01-01 15:26:06',
                'updated_at' => '2021-01-01 15:26:06',
            ];

            Menu::firstOrCreate($new_menus);
        } catch (Exception $e) {
            \DB::rollBack();
        }

        \DB::commit();
    }
}
