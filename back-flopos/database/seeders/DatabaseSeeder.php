<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();
        \App\Models\Category::factory(25)->create();
        \App\Models\Product::factory(80)->create();
        $user = User::where('username', 'user')->first();
        $admin = User::where('username', 'admin')->first();
        if (!$user) {
            User::create([
                'username' => 'user',
                'email' => 'user@gmail.com',
                'password' => Hash::make('user'),
            ]);
        }
        if (!$admin) {
            User::create([
                'username' => 'admin',
                'email' => 'admin@gmail.com',
                'password' => Hash::make('admin'),
            ]);
        }
    }
}
