<?php

namespace Database\Seeders\Badaso\GraphQL;

use Illuminate\Database\Seeder;
use Uasoft\Badaso\Models\Menu;
use Uasoft\Badaso\Models\MenuItem;

class BadasoGraphQLFixedMenuItemSeeder extends Seeder
{
    /**
     * Auto generated seed file.
     *
     * @throws Exception
     *
     * @return void
     */
    public function run()
    {
        \DB::beginTransaction();

        try {
            $menus = Menu::where('key', 'graphql-module')->first();
            $menu_id = $menus->id;

            $add_menus_item = [
                'menu_id' => $menu_id,
                'title' => 'GraphQL Playground',
                'url' => '/graphql',
                'target' => '_self',
                'icon_class' => 'grain',
                'color' => '',
                'parent_id' => null,
                'order' => 2,
                'permissions' => 'browse_graphql',
                'created_at' => '2021-01-01 15:26:06',
                'updated_at' => '2021-01-01 15:26:06',
            ];

            MenuItem::firstOrCreate($add_menus_item);
        } catch (Exception $e) {
            \DB::rollBack();
        }

        \DB::commit();
    }
}
