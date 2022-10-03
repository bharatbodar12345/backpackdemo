<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
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
        $user = User::updateOrCreate(['id' => 1],[
            'name'              => "Admin",
            'email'             => "admin@gmail.com",
            'email_verified_at' => date('Y-m-d H:i:s'),
            'password'          => Hash::make("12345678"),
            'created_at'        => date("Y-m-d H:i:s"),
            'updated_at'        => null
        ]);
        $user->assignRole('Admin');
    }
}
