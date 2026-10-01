<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::table('permissions')->updateOrInsert(
            ['name' => 'system-logs', 'guard_name' => 'web'],
            ['created_at' => now(), 'updated_at' => now()]
        );

        $permission = DB::table('permissions')->where('name', 'system-logs')->where('guard_name', 'web')->first();

        if (! $permission) {
            return;
        }

        $roles = DB::table('roles')
            ->whereIn('name', ['Admin', 'Super Admin'])
            ->where('guard_name', 'web')
            ->get();

        foreach ($roles as $role) {
            DB::table('role_has_permissions')->updateOrInsert([
                'permission_id' => $permission->id,
                'role_id' => $role->id,
            ]);
        }

        app(\Spatie\Permission\PermissionRegistrar::class)->forgetCachedPermissions();
    }

    public function down(): void
    {
        $permission = DB::table('permissions')->where('name', 'system-logs')->where('guard_name', 'web')->first();

        if ($permission) {
            $roleIds = DB::table('roles')
                ->whereIn('name', ['Admin', 'Super Admin'])
                ->where('guard_name', 'web')
                ->pluck('id');

            DB::table('role_has_permissions')
                ->where('permission_id', $permission->id)
                ->whereIn('role_id', $roleIds)
                ->delete();
        }

        app(\Spatie\Permission\PermissionRegistrar::class)->forgetCachedPermissions();
    }
};
