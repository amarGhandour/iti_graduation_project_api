<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

class PermissionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Reset cached roles and permissions
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        // create permissions
        $permissions = [
            'user_management_access',
            'permission_create',
            'permission_edit',
            'permission_show',
            'permission_delete',
            'permission_access',
            'role_create',
            'role_edit',
            'role_show',
            'role_delete',
            'role_access',
            'user_create',
            'user_edit',
            'user_show',
            'user_delete',
            'user_access',
            'product_create',
            'product_edit',
            'product_show',
            'product_delete',
            'product_access',
            'category_create',
            'category_edit',
            'category_show',
            'category_delete',
            'category_access',
            'coupon_create',
            'coupon_edit',
            'coupon_show',
            'coupon_delete',
            'coupon_access',
            'order_access',
            'order_create',
            'order_show',
            'order_edit',
            'order_delete',
            'review_access',
            'review_show',
            'slider_create',
            'slider_edit',
            'slider_delete',
            'slider_access',
        ];

        foreach ($permissions as $permission) {
            Permission::create([
                'name' => $permission,
                'guard_name' => 'api'
            ]);
        }

        // gets all permissions via Gate::before rule; see AuthServiceProvider
        Role::create(['name' => 'Super Admin', 'guard_name' => 'api']);

        $user = Role::create(['name' => 'User', 'guard_name' => 'api']);

        $userPermissions = [
            'product_show',
            'product_access',
            'category_show',
            'category_access',
            'order_create',
            'order_delete',
            'review_access',
            'review_show',
        ];

        foreach ($userPermissions as $permission) {
            $user->givePermissionTo($permission);
        }
    }
}
