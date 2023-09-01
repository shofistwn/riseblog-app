<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Role::insert([
            [
                'id'    => 1,
                'name'  => 'admin',
            ],
            [
                'id'    => 2,
                'name'  => 'author',
            ],
            [
                'id'    => 3,
                'name'  => 'reader',
            ],
        ]);
    }
}
