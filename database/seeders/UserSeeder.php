<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = User::where('email', 'aungpor.napat@gmail.com')->first();
        if (!$user) {
            $user = new User;
            $user->name = "aungpor";
            $user->role = 'USER';
            $user->email = 'aungpor.napat@gmail.com';
            $user->password = Hash::make('userpass');
            $user->phone_number = "1234567890";
            $user->save();
        }

        $user = User::where('email', 'user01@gmail.com')->first();
        if (!$user) {
            $user = new User;
            $user->name = "user01";
            $user->role = 'USER';
            $user->email = 'user01@gmail.com';
            $user->password = Hash::make('userpass');
            $user->phone_number = "0987654321";
            $user->save();
        }

        $user = User::where('email', 'admin@gmail.com')->first();
        if (!$user) {
            $user = new User;
            $user->name = "admin";
            $user->role = 'ADMIN';
            $user->email = 'admin@gmail.com';
            $user->password = Hash::make('adminpass');
            $user->phone_number = "0000000000";
            $user->save();
        }
    }
}
