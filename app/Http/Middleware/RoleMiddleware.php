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
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // Create permissions
        $permissions = [
            // Dashboard
            'view dashboard',
            
            // User Management
            'view users', 
            'create users', 
            'edit users', 
            'delete users',
            
            // Role Management
            'view roles', 
            'create roles', 
            'edit roles', 
            'delete roles',
            
            // Student Management
            'view students', 
            'create students', 
            'edit students', 
            'delete students',
            'import students',
            'export students',
            
            // Teacher Management
            'view teachers', 
            'create teachers', 
            'edit teachers', 
            'delete teachers',
            
            // Class Management
            'view classes', 
            'create classes', 
            'edit classes', 
            'delete classes',
            
            // Section Management
            'view sections', 
            'create sections', 
            'edit sections', 
            'delete sections',
            
            // Subject Management
            'view subjects', 
            'create subjects', 
            'edit subjects', 
            'delete subjects',
            
            // Exam Management
            'view exams', 
            'create exams', 
            'edit exams', 
            'delete exams',
            'manage exam results',
            
            // Attendance Management
            'view attendance', 
            'mark attendance', 
            'edit attendance',
            'view attendance report',
            
            // Fee Management
            'view fees', 
            'create fees', 
            'edit fees', 
            'delete fees',
            'collect fees',
            'view fee report',
            
            // Report Management
            'view reports',
            'generate reports',
        ];

        foreach ($permissions as $permission) {
            Permission::create(['name' => $permission]);
        }

        // Create roles
        $superAdminRole = Role::create(['name' => 'super-admin']);
        $adminRole = Role::create(['name' => 'admin']);
        $teacherRole = Role::create(['name' => 'teacher']);
        $studentRole = Role::create(['name' => 'student']);
        $parentRole = Role::create(['name' => 'parent']);
        $accountantRole = Role::create(['name' => 'accountant']);

        // Assign all permissions to super-admin
        $superAdminRole->givePermissionTo(Permission::all());
        
        // Assign permissions to admin
        $adminRole->givePermissionTo([
            'view dashboard',
            'view students', 'create students', 'edit students', 'delete students',
            'view teachers', 'create teachers', 'edit teachers', 'delete teachers',
            'view classes', 'create classes', 'edit classes', 'delete classes',
            'view sections', 'create sections', 'edit sections', 'delete sections',
            'view subjects', 'create subjects', 'edit subjects', 'delete subjects',
            'view exams', 'create exams', 'edit exams', 'delete exams',
            'view attendance', 'view attendance report',
            'view fees', 'create fees', 'edit fees', 'view fee report',
            'view reports',
        ]);

        // Assign permissions to teacher
        $teacherRole->givePermissionTo([
            'view dashboard',
            'view students',
            'view attendance', 'mark attendance', 'edit attendance', 'view attendance report',
            'view exams', 'manage exam results',
            'view reports',
        ]);

        // Assign permissions to accountant
        $accountantRole->givePermissionTo([
            'view dashboard',
            'view students',
            'view fees', 'collect fees', 'view fee report',
            'view reports',
        ]);

        // Assign permissions to student
        $studentRole->givePermissionTo([
            'view dashboard',
        ]);

        // Assign permissions to parent
        $parentRole->givePermissionTo([
            'view dashboard',
        ]);

        // Create Super Admin User
        $superAdmin = User::create([
            'name' => 'Super Admin',
            'email' => 'superadmin@school.com',
            'password' => bcrypt('password'),
            'phone' => '1234567890',
            'address' => 'Main Office',
            'status' => 'active',
        ]);
        $superAdmin->assignRole('super-admin');

        // Create Admin User
        $admin = User::create([
            'name' => 'Admin User',
            'email' => 'admin@school.com',
            'password' => bcrypt('password'),
            'phone' => '1234567890',
            'address' => 'Admin Office',
            'status' => 'active',
        ]);
        $admin->assignRole('admin');

        // Create Teacher User
        $teacher = User::create([
            'name' => 'Teacher User',
            'email' => 'teacher@school.com',
            'password' => bcrypt('password'),
            'phone' => '1234567890',
            'address' => 'Staff Room',
            'status' => 'active',
        ]);
        $teacher->assignRole('teacher');

        // Create Accountant User
        $accountant = User::create([
            'name' => 'Accountant User',
            'email' => 'accountant@school.com',
            'password' => bcrypt('password'),
            'phone' => '1234567890',
            'address' => 'Accounts Office',
            'status' => 'active',
        ]);
        $accountant->assignRole('accountant');

        // Create Student User (example)
        $student = User::create([
            'name' => 'Student User',
            'email' => 'student@school.com',
            'password' => bcrypt('password'),
            'phone' => '1234567890',
            'address' => 'Student Hostel',
            'status' => 'active',
        ]);
        $student->assignRole('student');

        // Create Parent User (example)
        $parent = User::create([
            'name' => 'Parent User',
            'email' => 'parent@school.com',
            'password' => bcrypt('password'),
            'phone' => '1234567890',
            'address' => 'Parent Address',
            'status' => 'active',
        ]);
        $parent->assignRole('parent');

        $this->command->info('Roles and permissions seeded successfully!');
        $this->command->info('Login credentials:');
        $this->command->info('Super Admin: superadmin@school.com / password');
        $this->command->info('Admin: admin@school.com / password');
        $this->command->info('Teacher: teacher@school.com / password');
        $this->command->info('Accountant: accountant@school.com / password');
    }
}