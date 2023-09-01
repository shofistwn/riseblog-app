<?php

namespace Database\Seeders;

use App\Models\PostCategory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PostCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        PostCategory::insert([
            [
                'post_id'       => 1,
                'category_id'   => 1,
            ],
            [
                'post_id'       => 1,
                'category_id'   => 2,
            ],
            [
                'post_id'       => 2,
                'category_id'   => 1,
            ],
            [
                'post_id'       => 3,
                'category_id'   => 1,
            ],
            [
                'post_id'       => 4,
                'category_id'   => 1,
            ],
            [
                'post_id'       => 4,
                'category_id'   => 2,
            ],
        ]);
    }
}
