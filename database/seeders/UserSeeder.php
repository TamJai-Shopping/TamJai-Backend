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
            $user->phone_number = "0811234445";
            $user->save();
        }
    }
}
