<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('users')->insert([
            'name' => 'Admin',
            'email' => 'admin@gmail.com',
            'usertype' => 'admin',
            'password' => Hash::make('admin'),

        ]);
        DB::table('users')->insert([
            'name' => 'Author',
            'email' => 'author@gmail.com',
            'usertype' => 'author',
            'password' => Hash::make('author'),

        ]);
        DB::table('users')->insert([
            'name' => 'Developers Team',
            'email' => 'dcsdevs@gmail.com',
            'usertype' => 'developers',
            'password' => Hash::make('dcsdevs@777'),

        ]);
    }
}
