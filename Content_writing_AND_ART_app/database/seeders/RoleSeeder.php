<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //Create roles
        $studentRole = Role::create(['name' => 'student']);
        $editorRole = Role::create(['name' => 'editor']);
        $adminRole = Role::create(['name' => 'admin']);

        // Create permissions
        $permissions = [
            'create content',
            'edit content',
            'delete content',
            'view content',
            'comment on content',
            'like content',
            'dislike content',
            'manage categories',
            'manage users',
            'approve content',
            'publish content',
            'view transactions',
            'manage transactions',
            'manage roles and permissions',
            'flag content',
            'view reports',
            'create art',
            'edit art',
            'delete art',
            'view art',
            'buy art',
            'suspend content'
        ];

        foreach ($permissions as $permission) {
            Permission::create(['name' => $permission]);
        }

        // Assign permissions to roles
        $studentRole->givePermissionTo([
            'create content',
            'edit content',
            'delete content',
            'publish content',
            'view content',
            'comment on content',
            'like content',
            'dislike content',
            'create art',
            'edit art',
            'delete art',
            'view art',
            'buy art'
        ]);

        $editorRole->givePermissionTo([
            'manage categories',
            'approve content',
            'flag content',
            'view reports',
            'buy art',
            'comment on content',
            'like content',
            'dislike content'
        ]);

        $adminRole->givePermissionTo([
            'suspend content',
            'view content',
            'comment on content',
            'like content',
            'dislike content',
            'manage categories',
            'manage users',
            'approve content',
            'view transactions',
            'manage transactions',
            'manage roles and permissions',
            'view reports',
            'view art',
            'buy art'
        ]);
    }
}



