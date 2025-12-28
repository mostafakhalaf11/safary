<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Role;
use App\Models\Permission;
use Spatie\Permission\PermissionRegistrar;

class RolesAndPermissionsSeeder extends Seeder
{
    protected string $guard = 'api';

    /**
     * All available permissions grouped by resource
     */
    private array $permissionsByResource = [
        'users' => ['view', 'create', 'edit', 'delete', 'manage'],
        'drivers' => ['view', 'create', 'edit', 'delete', 'manage'],
        'bookings' => ['view', 'create', 'edit', 'delete', 'manage'],
        'deliveries' => ['view', 'create', 'edit', 'delete', 'manage'],
        'roles' => ['view', 'create', 'edit', 'delete', 'manage'],
        'permissions' => ['view', 'create', 'edit', 'delete', 'manage'],
        'trips' => ['view', 'create', 'edit', 'delete', 'manage'],
        'tripStops' => ['view', 'create', 'edit', 'delete', 'manage'],
    ];

    /**
     * Role to permissions mapping
     */
    private array $rolePermissions = [
        'admin' => [
            'users' => ['view', 'create', 'edit', 'delete', 'manage'],
            'drivers' => ['view', 'create', 'edit', 'delete', 'manage'],
            'bookings' => ['view', 'create', 'edit', 'delete', 'manage'],
            'deliveries' => ['view', 'create', 'edit', 'delete', 'manage'],
            'roles' => ['view', 'create', 'edit', 'delete', 'manage'],
            'permissions' => ['view', 'create', 'edit', 'delete', 'manage'],
            'trips' => ['view', 'create', 'edit', 'delete', 'manage'],
            'tripStops' => ['view', 'create', 'edit', 'delete', 'manage'],
        ],
        'driver' => [
            'deliveries' => ['view', 'create', 'edit', 'delete', 'manage'],
            'trips' => ['view', 'create', 'edit', 'delete', 'manage'],
            'tripStops' => ['view', 'create', 'edit', 'delete', 'manage'],
        ],
        'customer' => [
            'bookings' => ['view', 'create', 'edit', 'delete', 'manage'],
            'tripStops' => ['view', 'create', 'edit', 'delete', 'manage'],
            'deliveries' => ['view', 'create', 'edit', 'delete', 'manage'],
            'trips' => ['view', 'create', 'edit', 'delete', 'manage'],
        ],
    ];

    public function run(): void
    {
        // Reset cached roles and permissions
        app(PermissionRegistrar::class)->forgetCachedPermissions();

        // Create all permissions first
        $this->createAllPermissions();

        // Create roles and assign permissions
        foreach ($this->rolePermissions as $roleName => $resources) {
            $role = Role::firstOrCreate([
                'name' => $roleName,
                'guard_name' => $this->guard,
            ]);

            $permissions = $this->buildPermissionNames($resources);
            $role->syncPermissions($permissions);
        }
    }

    /**
     * Create all permissions defined in $permissionsByResource
     */
    private function createAllPermissions(): void
    {
        foreach ($this->permissionsByResource as $resource => $actions) {
            foreach ($actions as $action) {
                Permission::firstOrCreate([
                    'name' => "{$action}-{$resource}",
                    'guard_name' => $this->guard,
                ]);
            }
        }
    }

    /**
     * Build permission names from resource/action mapping
     */
    private function buildPermissionNames(array $resources): array
    {
        $permissions = [];

        foreach ($resources as $resource => $actions) {
            foreach ($actions as $action) {
                $permissions[] = "{$action}-{$resource}";
            }
        }

        return $permissions;
    }
}
