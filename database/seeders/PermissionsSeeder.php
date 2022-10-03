<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;


class PermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $guard = "web";
        $permission = [
            'users',
            
        ];
        foreach($permission as $key => $item) {
            Permission::updateOrCreate(['name' => "$item-create"], [
                'name'          => "$item-create",
                'guard_name'    => "$guard",
            ]);
            Permission::updateOrCreate(['name' => "$item-edit"], [
                'name'          => "$item-edit",
                'guard_name'    => "$guard",
            ]);
            Permission::updateOrCreate(['name' => "$item-view"], [
                'name'          => "$item-view",
                'guard_name'    => "$guard",
            ]);
            Permission::updateOrCreate(['name' => "$item-delete"], [
                'name'          => "$item-delete",
                'guard_name'    => "$guard",
            ]);
        }
    }
}
