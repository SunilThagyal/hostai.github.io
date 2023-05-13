<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = [
            ['first_name' => 'Admin', 'slug' => 'admin', 'role' => 'admin','status' => 'Active', 'email' => 'pablo@gmail.com', 'password' => Hash::make('Shine@123')],
        ];

        User::insert($users);
    }
}
