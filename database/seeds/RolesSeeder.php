<?php

use App\Role;
use Illuminate\Database\Seeder;

class RolesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Role::create([
            'name' => 'Admin',
            'display_name' => 'Admin',
            'description' => 'System administrator.',
            'removable' => false
        ]);

        Role::create([
            'name' => 'User',
            'display_name' => 'User',
            'description' => 'Default system user.',
            'removable' => false
        ]);
        Role::create([
            'name' => 'Wakalah',
            'display_name' => 'Wakalah',
            'description' => 'Default system user.',
            'removable' => false
        ]);
        Role::create([
            'name' => 'State Manager',
            'display_name' => 'State Manager',
            'description' => 'Default system user.',
            'removable' => false
        ]);
        Role::create([
            'name' => 'HQ',
            'display_name' => 'HQ',
            'description' => 'Default system user.',
            'removable' => false
        ]);
    }
}
