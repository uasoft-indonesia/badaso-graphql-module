<?php

use Illuminate\Database\Seeder;

class BadasoGraphQLModuleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call(BadasoGraphQLPermissionsSeeder::class);
        $this->call(BadasoGraphQLRolePermissionsSeeder::class);
        $this->call(BadasoGraphQLMenusSeeder::class);
        $this->call(BadasoGraphQLFixedMenuItemSeeder::class);
    }
}
