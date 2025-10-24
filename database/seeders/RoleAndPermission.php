<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleAndPermission extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $roleadmin = Role::firstOrCreate([
            'name' => 'administrador',
        ]);

        $rolevisitor = Role::firstOrCreate([
            'name' => 'visiatante',
        ]);

        Permission::firstOrCreate([
            'name' => 'admin',
        ]);

        Permission::firstOrCreate([
            'name' => 'visita',
        ]);

        $roleadmin->givePermissionTo('admin');
        $rolevisitor->givePermissionTo('visita');
    }
}
