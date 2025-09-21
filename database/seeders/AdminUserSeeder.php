<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     * 
     * This seeder creates the admin user for secret page access.
     * Run with: php artisan db:seed --class=AdminUserSeeder
     */
    public function run(): void
    {
        // Check if admin user already exists
        $adminExists = User::where('email', 'protagonist@temperance.com')->exists();
        
        if ($adminExists) {
            $this->command->info('Admin user already exists.');
            return;
        }

        // Create admin user for secret page access
        User::create([
            'name' => 'Protagonist Admin',
            'email' => 'protagonist@temperance.com',
            'password' => Hash::make('cangkirtemperance'),
            'email_verified_at' => now(),
            'bio' => 'System Administrator',
        ]);

        $this->command->info('✅ Admin user created successfully!');
        $this->command->info('📧 Email: protagonist@temperance.com');
        $this->command->info('🔑 Password: cangkirtemperance');
        $this->command->info('🔒 Access: Secret Admin Dashboard');
    }
}
