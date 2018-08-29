<?php

use App\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Task;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $first_user = [
            'name' => 'Vitalii Ivanov',
            'email' => 'vitalii.ivanov1983@gmail.com',
            'daily' => '1',
            'password' => Hash::make('111111')
        ];

        $user = User::create($first_user);

        $faker = \Faker\Factory::create();

        for ($i = 0; $i < 20; $i++) {
            $tasks = [
                'user_id' => $user->id,
                'title' => $faker->text(70),
                'task' => $faker->text(200),
                'status' => $faker->randomElement(['on', 'done']),
                'urgency' => $faker->randomElement([1, 0]),
                'importance' => $faker->randomElement([1, 0]),
            ];

            Task::create($tasks);
        }

        //factory(\App\User::class,3)->create();
    }
}
