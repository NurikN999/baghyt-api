<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserRolesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $roles = [
            'admin',
            'user',
        ];

        $user = User::where('name', 'Admin')->first();

        foreach ($roles as $role) {
            \Spatie\Permission\Models\Role::create([
                'name' => $role,
            ]);
        }

        $user->assignRole('admin');
        
    }
}
