<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // Create Roles
        $adminRole = Role::firstOrCreate(['name' => 'admin']);
        $panitiaRole = Role::firstOrCreate(['name' => 'panitia']);

        // Assign Admin Role to existing Admin User
        $adminUser = User::where('email', 'admin@example.com')->first();
        if ($adminUser) {
            $adminUser->assignRole($adminRole);
        } else {
            // Fallback if admin doesn't exist
            $adminUser = User::create([
                'name' => 'Admin Application',
                'email' => 'admin@example.com',
                'password' => Hash::make('password'),
            ]);
            $adminUser->assignRole($adminRole);
        }

        // Create Panitia User
        $panitiaUser = User::firstOrCreate(
            ['email' => 'panitia@example.com'],
            [
                'name' => 'Panitia Lomba',
                'password' => Hash::make('password'),
            ]
        );
        $panitiaUser->assignRole($panitiaRole);
    }
}
