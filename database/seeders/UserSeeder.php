<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::insert([
            [
                'id'            => 1,
                'role_id'       => 1,
                'username'      => 'user1',
                'name'          => 'User Admin',
                'email'         => 'user1@mail.com',
                'password'      => bcrypt('password'),
                'created_at'    => now(),
                'updated_at'    => now(),
            ],
            [
                'id'            => 2,
                'role_id'       => 2,
                'username'      => 'user2',
                'name'          => 'User Author',
                'email'         => 'user2@mail.com',
                'password'      => bcrypt('password'),
                'created_at'    => now(),
                'updated_at'    => now(),
            ],
            [
                'id'            => 3,
                'role_id'       => 3,
                'username'      => 'user3',
                'name'          => 'User Reader',
                'email'         => 'user3@mail.com',
                'password'      => bcrypt('password'),
                'created_at'    => now(),
                'updated_at'    => now(),
            ],
        ]);
    }
}
