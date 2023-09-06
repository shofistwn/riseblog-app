<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Helpers\ImageHelper;
use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Post;
use Illuminate\Support\Str;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class PostController extends Controller
{
    public $limit = 12;

    public function list(Request $request) : JsonResponse {
        $username       = $request->input('username', null);
        $categorySlug   = $request->input('category', null);
        $published      = $request->input('published', 1);
        $orderBy        = $request->input('order_by', 'desc');
        $limit          = $request->input('limit', $this->limit);

        $query = Post::when($published, function ($query, $published) {
            if (is_int($published)) {
                return $query->where('published', $published);
            }
        })
            ->with(['user:id,username,name', 'categories'])
            ->orderBy('id', $orderBy);

        if ($username) {
            $query->whereHas('user', function ($userQuery) use ($username) {
                $userQuery->where('username', $username);
            });
        }

        if ($categorySlug) {
            $query->whereHas('categories', function ($categoryQuery) use ($categorySlug) {
                $categoryQuery->where('slug', $categorySlug);
            });
        }

        $posts = $query->paginate($limit)->toArray();

        $this->message  = 'List of Posts';
        $this->data     = $posts;

        return $this->createResponse($this->success, $this->message, $this->data, $this->code);
    }

    public function create(Request $request) : JsonResponse {
        $userId         = auth()->user()->id;
        $thumbnail      = $request->file('thumbnail');
        $title          = $request->input('title');
        $summary        = $request->input('summary');
        $content        = $request->input('content');
        $published      = $request->input('published', 0);
        $publishedAt    = $published ? now() : null;
        $categories     = $request->input('categories', null);

        try {
            $validator = Validator::make($request->all(), [
                'thumbnail'     => 'image|max:2048',
                'title'         => 'required|string',
                'summary'       => 'required|string',
                'content'       => 'required|string',
                'categories'    => 'array',
            ]);

            if ($validator->fails()) {
                throw new Exception($validator->errors()->first(), 422);
            }

            DB::beginTransaction();

            if ($request->hasFile('thumbnail')) {
                $thumbnail = ImageHelper::saveImage($thumbnail, 'posts', Str::slug($title));
            } else {
                $thumbnail = null;
            }

            $post = Post::create([
                'user_id'       => $userId,
                'thumbnail'     => $thumbnail,
                'title'         => $title,
                'summary'       => $summary,
                'content'       => $content,
                'published'     => $published,
                'published_at'  => $publishedAt,
            ]);

            if ($categories) {
                $categoryIds = [];

                foreach ($categories as $value) {
                    $category = Category::firstOrCreate([
                        'title' => $value,
                        'slug'  => Str::slug($value),
                    ]);

                    array_push($categoryIds, $category->id);
                }

                $post->categories()->attach($categoryIds);
            }

            DB::commit();

            $this->message = 'Post created successfully';
        } catch (Exception $e) {
            DB::rollBack();

            $this->success  = false;
            $this->message  = $e->getMessage();
            $this->code     = $e->getCode();
        }

        return $this->createResponse($this->success, $this->message, $this->data, $this->code);
    }

    public function update(Request $request, string $postSlug) : JsonResponse {
        $userId         = auth()->user()->id;
        $thumbnail      = $request->file('thumbnail');
        $title          = $request->input('title');
        $summary        = $request->input('summary');
        $content        = $request->input('content');
        $published      = $request->input('published', 0);
        $categories     = $request->input('categories', null);

        try {
            $validator = Validator::make($request->all(), [
                'thumbnail'     => 'image|max:2048',
                'title'         => 'required|string',
                'summary'       => 'required|string',
                'content'       => 'required|string',
                'categories'    => 'array',
            ]);

            if ($validator->fails()) {
                throw new Exception($validator->errors()->first(), 422);
            }

            DB::beginTransaction();

            $post = Post::where('slug', $postSlug)
                ->first();

            if (!$post) {
                throw new Exception('Post not found', 404);
            }

            if ($request->hasFile('thumbnail')) {
                $thumbnail = ImageHelper::saveImage($thumbnail, 'posts', Str::slug($title));

                if ($post->thumbnail) {
                    ImageHelper::deleteImage('posts', $post->thumbnail);
                }
            } else {
                $thumbnail = $post->thumbnail;
            }

            $publishedAt = $published ? now() : $post->published_at;

            $post->update([
                'user_id'       => $userId,
                'thumbnail'     => $thumbnail,
                'title'         => $title,
                'summary'       => $summary,
                'content'       => $content,
                'published'     => $published,
                'published_at'  => $publishedAt,
            ]);

            if ($categories) {
                $categoryIds = [];

                foreach ($categories as $value) {
                    $category = Category::firstOrCreate([
                        'title' => $value,
                        'slug'  => Str::slug($value),
                    ]);

                    array_push($categoryIds, $category->id);
                }

                $post->categories()->sync($categoryIds);
            }

            DB::commit();

            $this->message = 'Post updated successfully';
        } catch (Exception $e) {
            DB::rollBack();

            $this->success  = false;
            $this->message  = $e->getMessage();
            $this->code     = $e->getCode();
        }

        return $this->createResponse($this->success, $this->message, $this->data, $this->code);
    }

    public function show(string $postSlug) : JsonResponse {
        try {
            $post = Post::where('slug', $postSlug)
                ->with(['user:id,username,name', 'categories'])
                ->first();

            if (!$post) {
                throw new Exception('Post not found', 404);
            }

            $post->toArray();

            $this->message  = 'Post detail';
            $this->data     = $post;
        } catch (Exception $e) {
            $this->success  = false;
            $this->message  = $e->getMessage();
            $this->code     = $e->getCode();
        }

        return $this->createResponse($this->success, $this->message, $this->data, $this->code);
    }

    public function delete(string $postSlug) : JsonResponse {
        try {
            $post = Post::where('slug', $postSlug)->first();

            if (!$post) {
                throw new Exception('Post not found', 404);
            }

            if ($post->thumbnail) {
                Storage::delete('public/posts/' . $post->thumbnail);
            }

            $post->categories()->detach();
            $post->delete();

            $this->message = 'Post deleted successfully';
        } catch (Exception $e) {
            $this->success  = false;
            $this->message  = $e->getMessage();
            $this->code     = $e->getCode();
        }
        return $this->createResponse($this->success, $this->message, $this->data, $this->code);
    }
}
