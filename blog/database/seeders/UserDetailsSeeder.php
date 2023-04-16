<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\UserDetail;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserDetailsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = UserDetail::create([
            'address' => 'Viet nam',
            'phone' => '123456789',
            'identity_card_number' => '123123',
            'user_id' => User::first()->id
        ]);
    }
}
