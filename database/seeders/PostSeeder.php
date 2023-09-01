<?php

namespace Database\Seeders;

use App\Models\Post;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PostSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Post::insert([
            'id'            => 1,
            'user_id'       => 1,
            'title'         => 'This is First Article',
            'slug'          => 'this-is-first-article',
            'summary'       => 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Cumque aspernatur officia soluta dolor voluptatem laborum expedita nemo. Est ut, non et alias quos dolores, quae eaque cum voluptatibus quam odit.',
            'content'       => 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Voluptatem consectetur repellendus aut? Doloribus mollitia corrupti quidem natus quisquam adipisci saepe excepturi vitae, magnam sunt dignissimos officiis, labore est! Vitae, amet!',
            'published'     => 1,
            'published_at'  => now(),
            'created_at'    => now(),
            'updated_at'    => now(),
        ]);

        Post::insert([
            'id'            => 2,
            'user_id'       => 1,
            'title'         => 'This is Second Article',
            'slug'          => 'this-is-second-article',
            'summary'       => 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Cumque aspernatur officia soluta dolor voluptatem laborum expedita nemo. Est ut, non et alias quos dolores, quae eaque cum voluptatibus quam odit.',
            'content'       => 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Voluptatem consectetur repellendus aut? Doloribus mollitia corrupti quidem natus quisquam adipisci saepe excepturi vitae, magnam sunt dignissimos officiis, labore est! Vitae, amet!',
            'published'     => 0,
            'created_at'    => now(),
            'updated_at'    => now(),
        ]);

        Post::insert([
            'id'            => 3,
            'user_id'       => 2,
            'title'         => 'This is Third Article',
            'slug'          => 'this-is-third-article',
            'summary'       => 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Cumque aspernatur officia soluta dolor voluptatem laborum expedita nemo. Est ut, non et alias quos dolores, quae eaque cum voluptatibus quam odit.',
            'content'       => 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Voluptatem consectetur repellendus aut? Doloribus mollitia corrupti quidem natus quisquam adipisci saepe excepturi vitae, magnam sunt dignissimos officiis, labore est! Vitae, amet!',
            'published'     => 1,
            'published_at'  => now(),
            'created_at'    => now(),
            'updated_at'    => now(),
        ]);

        Post::insert([
            'id'            => 4,
            'user_id'       => 2,
            'title'         => 'This is Fourth Article',
            'slug'          => 'this-is-fourth-article',
            'summary'       => 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Cumque aspernatur officia soluta dolor voluptatem laborum expedita nemo. Est ut, non et alias quos dolores, quae eaque cum voluptatibus quam odit.',
            'content'       => 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Voluptatem consectetur repellendus aut? Doloribus mollitia corrupti quidem natus quisquam adipisci saepe excepturi vitae, magnam sunt dignissimos officiis, labore est! Vitae, amet!',
            'published'     => 0,
            'created_at'    => now(),
            'updated_at'    => now(),
        ]);
    }
}
