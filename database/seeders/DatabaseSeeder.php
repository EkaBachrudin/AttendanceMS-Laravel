<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Role;
use Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $user = User::create([
            'name' => 'Admin',
            'email' => 'admin@mail.com',
            'password' => Hash::make('admin123'),
        ]);
        $role = Role::create([
            'slug' => 'admin',
            'name' => 'Adminstrator',
        ]);
        $user->roles()->sync($role->id);
        $role = Role::create([
            'slug' => 'user',
            'name' => 'User',
        ]);
    }
}
