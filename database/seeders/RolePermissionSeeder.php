<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\User;

class RolePermissionSeeder extends Seeder
{
    public function run()
    {
        // Comment out this line to avoid cache issues
        // app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // Create permissions
        $permissions = [
            'view users', 'create users', 'edit users', 'delete users',
            'view roles', 'create roles', 'edit roles', 'delete roles',
            'view students', 'create students', 'edit students', 'delete students',
            'view teachers', 'create teachers', 'edit teachers', 'delete teachers',
            'view classes', 'create classes', 'edit classes', 'delete classes',
            'view subjects', 'create subjects', 'edit subjects', 'delete subjects',
            'view exams', 'create exams', 'edit exams', 'delete exams',
            'view attendance', 'mark attendance', 'edit attendance',
            'view fees', 'create fees', 'edit fees', 'delete fees',
            'view dashboard',
        ];

        foreach ($permissions as $permission) {
            // Check if permission already exists
            if (!Permission::where('name', $permission)->exists()) {
                Permission::create(['name' => $permission]);
            }
        }

        // Create roles with checking if they exist
        $superAdminRole = Role::firstOrCreate(['name' => 'super-admin']);
        $adminRole = Role::firstOrCreate(['name' => 'admin']);
        $teacherRole = Role::firstOrCreate(['name' => 'teacher']);
        $studentRole = Role::firstOrCreate(['name' => 'student']);
        $parentRole = Role::firstOrCreate(['name' => 'parent']);
        $accountantRole = Role::firstOrCreate(['name' => 'accountant']);

        // Assign permissions to roles
        $superAdminRole->syncPermissions(Permission::all());
        
        $adminRole->syncPermissions([
            'view students', 'create students', 'edit students', 'delete students',
            'view teachers', 'create teachers', 'edit teachers', 'delete teachers',
            'view classes', 'create classes', 'edit classes', 'delete classes',
            'view subjects', 'create subjects', 'edit subjects', 'delete subjects',
            'view exams', 'create exams', 'edit exams', 'delete exams',
            'view attendance', 'view fees',
            'view dashboard',
        ]);

        $teacherRole->syncPermissions([
            'view students', 'view attendance', 'mark attendance', 'edit attendance',
            'view dashboard',
        ]);

        $accountantRole->syncPermissions([
            'view students', 'view fees', 'create fees', 'edit fees',
            'view dashboard',
        ]);

        // Create users if they don't exist
        // Super Admin
        $superAdmin = User::firstOrCreate(
            ['email' => 'superadmin@school.com'],
            [
                'name' => 'Super Admin',
                'password' => bcrypt('password'),
                'phone' => '1234567890',
                'status' => 'active',
            ]
        );
        if (!$superAdmin->hasRole('super-admin')) {
            $superAdmin->assignRole('super-admin');
        }

        // Admin
        $admin = User::firstOrCreate(
            ['email' => 'admin@school.com'],
            [
                'name' => 'Admin User',
                'password' => bcrypt('password'),
                'phone' => '1234567890',
                'status' => 'active',
            ]
        );
        if (!$admin->hasRole('admin')) {
            $admin->assignRole('admin');
        }

        // Teacher
        $teacher = User::firstOrCreate(
            ['email' => 'teacher@school.com'],
            [
                'name' => 'Teacher User',
                'password' => bcrypt('password'),
                'phone' => '1234567890',
                'status' => 'active',
            ]
        );
        if (!$teacher->hasRole('teacher')) {
            $teacher->assignRole('teacher');
        }

        // Accountant
        $accountant = User::firstOrCreate(
            ['email' => 'accountant@school.com'],
            [
                'name' => 'Accountant User',
                'password' => bcrypt('password'),
                'phone' => '1234567890',
                'status' => 'active',
            ]
        );
        if (!$accountant->hasRole('accountant')) {
            $accountant->assignRole('accountant');
        }

        $this->command->info('========================================');
        $this->command->info('Roles and permissions seeded successfully!');
        $this->command->info('========================================');
        $this->command->info('Login Credentials:');
        $this->command->info('Super Admin: superadmin@school.com / password');
        $this->command->info('Admin: admin@school.com / password');
        $this->command->info('Teacher: teacher@school.com / password');
        $this->command->info('Accountant: accountant@school.com / password');
        $this->command->info('========================================');
    }
}