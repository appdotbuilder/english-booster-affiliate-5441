<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create admin user
        User::create([
            'name' => 'Admin English Booster',
            'email' => 'admin@englishbooster.com',
            'password' => Hash::make('admin123'),
            'role' => 'admin',
            'is_active' => true,
            'bio' => 'Administrator of English Booster affiliate system.',
            'phone' => '+62812345678901',
        ]);

        // Create sample affiliate users
        $affiliates = [
            [
                'name' => 'Sarah Johnson',
                'email' => 'sarah@example.com',
                'password' => Hash::make('password'),
                'role' => 'affiliate',
                'commission_rate' => 15.00,
                'is_active' => true,
                'bio' => 'English teacher and education enthusiast. Helping students achieve their language goals.',
                'phone' => '+62812345678902',
            ],
            [
                'name' => 'Michael Chen',
                'email' => 'michael@example.com',
                'password' => Hash::make('password'),
                'role' => 'affiliate',
                'commission_rate' => 12.00,
                'is_active' => true,
                'bio' => 'Digital marketer specializing in education products. Passionate about English learning.',
                'phone' => '+62812345678903',
            ],
            [
                'name' => 'Lisa Williams',
                'email' => 'lisa@example.com',
                'password' => Hash::make('password'),
                'role' => 'affiliate',
                'commission_rate' => 18.00,
                'is_active' => true,
                'bio' => 'Former TOEFL instructor with 5 years of experience in English education.',
                'phone' => '+62812345678904',
            ],
            [
                'name' => 'David Kumar',
                'email' => 'david@example.com',
                'password' => Hash::make('password'),
                'role' => 'affiliate',
                'commission_rate' => 10.00,
                'is_active' => true,
                'bio' => 'Online influencer focused on language learning and study abroad programs.',
                'phone' => '+62812345678905',
            ],
            [
                'name' => 'Emma Thompson',
                'email' => 'emma@example.com',
                'password' => Hash::make('password'),
                'role' => 'affiliate',
                'commission_rate' => 20.00,
                'is_active' => false,
                'bio' => 'Freelance English tutor with expertise in business English and TOEFL preparation.',
                'phone' => '+62812345678906',
            ],
        ];

        foreach ($affiliates as $affiliate) {
            User::create($affiliate);
        }
    }
}