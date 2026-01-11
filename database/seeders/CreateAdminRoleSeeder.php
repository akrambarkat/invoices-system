<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class CreateAdminRoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // إنشاء دور الإدمن
        $adminRole = Role::firstOrCreate(['name' => 'Admin']);

        // تعيين جميع الصلاحيات لدور الإدمن
        $permissions = Permission::all();
        $adminRole->syncPermissions($permissions);
    }
}
