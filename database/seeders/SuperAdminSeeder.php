<?php

namespace Database\Seeders;

use App\Models\User;
use App\Enums\RoleEnum;
use App\Models\Admin;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class SuperAdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $admin = User::create([
            'first_name' => 'Super',
            'last_name' => 'Admin',
            'email' => 'superadmin@glimpse.com',
            'phone' => '09033987418',
            'dob' => '2025-04-25',
            'gender' => 'Female',
            'role' => RoleEnum::ADMIN,
            'email_verified_at' => now(),
            'password' => Hash::make('password'),
            'is_active' => true,
        ]);

        Admin::create([
            'user_id' => $admin->id,
        ]);
    }
}
