<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Role::updateOrCreate(['name' => 'Admin'], [
            'name'        => 'Admin',
            'guard_name' => 'web',
        ]);

        Role::updateOrCreate(['name' => 'Buyer'], [
            'name'        => 'Buyer',
            'guard_name' => 'web',
        ]);
        
        Role::updateOrCreate(['name' => 'Seller'], [
            'name'        => 'Seller',
            'guard_name' => 'web',
        ]);
    }
}
