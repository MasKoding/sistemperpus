<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        $users = [
            [
                'username'=>'manager',
                'name'=>'Akun manager',
                'email'=>'manager@gmail.com',
                'level'=>'manager',
                // merubah string menjadi random string pakai bcrypt
                'password'=>bcrypt('123456')
            ],
            [
                'username'=>'executive',
                'name'=>'Akun Executive',
                'email'=>'executive@gmail.com',
                'level'=>'executive',
                // merubah string menjadi random string pakai bcrypt
                'password'=>bcrypt('123456')
            ],
        ];

        foreach ($users as $key => $value) {
            // insert record ke table user
            User::create($value);
        }  
    }
}
