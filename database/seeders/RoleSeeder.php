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
    const ROLE_ADMIN = "ADMIN";
    const ROLE_USER = "USER";
    public function run()
    {
      $roles = [self::ROLE_ADMIN, self::ROLE_USER];

      foreach ($roles as $role) {
          Role::create(['name' => $role]);
      }
    }
}
