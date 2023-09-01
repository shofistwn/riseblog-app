<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Category::insert([
            [
                'id'    => 1,
                'title' => 'Laravel',
                'slug'  => 'laravel',
            ],
            [
                'id'    => 2,
                'title' => 'Web Development',
                'slug'  => 'web-development',
            ],
        ]);
    }
}
