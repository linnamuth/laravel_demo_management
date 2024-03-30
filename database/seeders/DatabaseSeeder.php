<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class DatabaseSeeder extends Seeder
{

    /**
     * List of applications to add.
     */
    private $permissions = [
        'user-list',
        'user-create',
        'user-edit',
        'user-delete',
        'role-list',
        'role-create',
        'role-edit',
        'role-delete',
        'product-list',
        'product-create',
        'product-edit',
        'product-delete',
        'leave-list',
        'leave-create',
        'leave-edit',
        'leave-delete',
        'mission-list',
        'mission-create',
        'mission-edit',
        'mission-delete',
        'department-list',
        'department-create',
        'department-edit',
        'department-delete',
        'leave_reject',
        'leave_approve',
        'mission_reject',
        'mission_approve',
        
    ];


    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        foreach ($this->permissions as $permission) {
            Permission::create(['name' => $permission]);
        }

        // Create admin User and assign the role to him.
        $user = User::create([
            'name' => 'Linna Muth',
            'email' => 'linna@example.com',
            'password' => Hash::make('password')
        ]);

        // Create Admin role if not exists
        $role = Role::firstOrCreate(['name' => 'Admin']);

        $permissions = Permission::pluck('id')->all();
        $role->syncPermissions($permissions);

        $user->assignRole($role);

        $user->update(['role_id' => 1]);
    }
}
