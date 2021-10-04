<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Constants\Resource;

class RoleHasPermissionSeeder extends Seeder
{
    public function run()
    {
        $this->createAdminRolePermissions();
        $this->createModeratorRolePermissions();
    }

    /**
     * Creates the permissions for the role Admin
     */
    private function createAdminRolePermissions()
    {
        $role = Role::findByName('ADMIN');
        $role->syncPermissions(Permission::all());
    }

    /**
     * Creates the permissions for the role Moderator
     */
    private function createModeratorRolePermissions()
    {
        $role = Role::findByName('USER');
        $role->syncPermissions(
            Permission::whereIn(
                'name', 
                [Resource::USER_SHOW, 
                Resource::USER_UPDATE]
                )->get());

        
    }
}
