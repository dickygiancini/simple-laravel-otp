<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\User\UsersBalanceInfo;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class PriviledgedUsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        $user = User::create([
            'name' => 'Dicky Giancini Arwindo Kurniawan',
            'email' => 'dicky.giancini.123@gmail.com',
            'password' => Hash::make('Dicky123#'),
            'pin' => Hash::make('050699'),
            'is_verified' => true,
            'email_verified_at' => Carbon::now(),
            'role_id' => 1
        ]);

        UsersBalanceInfo::create([
            'user_id' => $user->id,
            'balance' => 1000000000
        ]);
    }
}
