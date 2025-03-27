<?php

// Individual seeders for users
// database/seeders/UsersSeeder.php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\Student;
use App\Models\Teacher;
use App\Models\Admin;

class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create a student
        Student::create([
            'student_name' => 'John Doe',
            'email' => 'student@example.com',
            'password' => Hash::make('password123'),
            'set_active' => 'active',
        ]);

        // Create a teacher
        Teacher::create([
            'teacher_name' => 'Jane Smith',
            'email' => 'teacher@example.com',
            'password' => Hash::make('password123'),
            'set_active' => 'active',
        ]);

        // Create an admin
        Admin::create([
            'email' => 'admin@example.com',
            'password' => Hash::make('password123'),
        ]);
    }
}

// You can run this specific seeder with:
// php artisan db:seed --class=UsersSeeder