<?php

use App\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $main_user = [
            'name' => 'Vitalii Ivanov',
            'email' => 'vitalii.ivanov1983@gmail.com',
            'password' => Hash::make('111111')
        ];

        User::create($main_user);

        factory(\App\User::class,3)->create();
    }
}
