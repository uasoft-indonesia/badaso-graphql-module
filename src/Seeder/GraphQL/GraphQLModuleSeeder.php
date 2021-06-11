<?php

namespace Database\Seeders\Badaso\GraphQL;

use Illuminate\Database\Seeder;

class GraphQLModuleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call(GraphQLPermissionsSeeder::class);
        $this->call(GraphQLRolePermissionsSeeder::class);
        $this->call(GraphQLMenusSeeder::class);
        $this->call(GraphQLFixedMenuItemSeeder::class);
    }
}
