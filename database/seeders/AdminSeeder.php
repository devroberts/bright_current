<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = User::create([
            'name'              => 'Noor E Alam',
            'email'             => 'noor@slynerds.com',
            'email_verified_at' => now(),
            'password'          => Hash::make('12345678')
        ]);

        $user->assignRole('Admin');
    }
}
