<?php

namespace Database\Seeders;

use App\Models\Users;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Users::insert([
            [
                'name' => 'Raisyad Jullfikar',
                'email' => 'raisyadjullfikar@upi.edu',
                'password' => Hash::make('123456'),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
                'role_id' => 1,
            ],
            [
                'name' => 'Dummy User 1',
                'email' => 'duser@gmail.com',
                'password' => Hash::make('123456'),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
                'role_id' => 2,
            ],
        ]);
    }
}
