<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DummyUsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $userData = [
            [
                'name' => 'admin',
                'email' => 'admin@gmail.com',
                'role' => 'admin',
                'password' => bcrypt('1234'),
            ],
            [
                'name' => 'leader',
                'email' => 'leader@gmail.com',
                'role' => 'leader',
                'password' => bcrypt('1234'),
            ],
            [
                'name' => 'student',
                'email' => 'student@gmail.com',
                'role' => 'student',
                'password' => bcrypt('1234'),
            ]
        ];

        foreach ($userData as $key => $val) {
            User::create($val);
        }
    }
}
