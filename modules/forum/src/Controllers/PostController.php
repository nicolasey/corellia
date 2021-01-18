<?php

namespace Modules\Forum\Controllers;

use Modules\Forum\Models\Post;
use Modules\Forum\Models\Topic;
use App\Http\Controllers\Controller;

class PostController extends Controller
{
    /**
     * Get all posts for a topic, in order of appearance
     *
     * @param Topic $topic
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function index(Topic $topic)
    {
        return $topic->posts()->with("author")->get();
    }

    /**
     * Get a post
     *
     * @param Topic $topic
     * @param Post $post
     * @return Post
     */
    public function show(Topic $topic, Post $post)
    {
        $post->load("topic", "author");
        return $post;
    }

    /**
     * Store a post in a topic
     *
     * @param Topic $topic
     * @return mixed
     * @throws \Exception
     */
    public function store(Topic $topic)
    {
        $data = request()->only("content");
        $data['topic_id'] = $topic->id;
        $data['author'] = auth()->user()->getAuthIdentifier();

        try {
            $post = Post::create($data);
            return $post;
        } catch (\Exception $exception) {
            throw $exception;
        }
    }

    /**
     * Update a topic
     *
     * @param Topic $topic
     * @param Post $post
     * @return Post
     * @throws \Exception
     */
    public function update(Topic $topic, Post $post)
    {
        $data = request()->only("content", "author");

        // @todo if not admin, pluck out author

        try {
            $post->update($data);
            return $post;
        } catch (\Exception $exception) {
            throw $exception;
        }
    }

    /**
     * Destroy a post
     *
     * @param Topic $topic
     * @param Post $post
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function destroy(Topic $topic, Post $post)
    {
        try {
            $post->delete();
            return response()->json();
        } catch (\Exception $exception) {
            throw $exception;
        }
    }
}
