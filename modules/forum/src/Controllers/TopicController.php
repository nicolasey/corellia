<?php
namespace Modules\Forum\Controllers;

use Modules\Forum\Models\Forum;
use Modules\Forum\Models\Topic;
use App\Http\Controllers\Controller;

class TopicController extends Controller
{
    /**
     * Get forum with all topics
     *
     * @param Forum $forum
     * @return Forum
     */
    public function index(Forum $forum)
    {
        $forum->load("topics", "topics.lastPost");
        return $forum;
    }

    /**
     * Store a topic
     *
     * @param Forum $forum
     * @return mixed
     * @throws \Exception
     */
    public function store(Forum $forum)
    {
        $data = request()->only("name");
        $data['forum_id'] = $forum->id;
        $data['author_id'] = auth()->user()->getAuthIdentifier();

        try {
            $topic = Topic::create($data);
            return $topic;
        } catch (\Exception $exception) {
            throw $exception;
        }
    }

    /**
     * Store a topic
     *
     * @param Forum $forum
     * @param Topic $topic
     * @return Topic
     */
    public function show(Forum $forum, Topic $topic)
    {
        $topic->load("forum", "posts", "followers");
        return $topic;
    }

    /**
     * Update a topic
     *
     * @param Forum $forum
     * @param Topic $topic
     * @return Topic
     * @throws \Exception
     */
    public function update(Forum $forum, Topic $topic)
    {
        $data = request()->only("name", "author", "topic_id");

        // @todo filter data depending on permissions

        try {
            $topic->update($data);
            return $topic;
        } catch (\Exception $exception) {
            throw $exception;
        }
    }

    /**
     * Delete a topic
     *
     * @param Forum $forum
     * @param Topic $topic
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function destroy(Forum $forum, Topic $topic)
    {
        try {
            $topic->delete();
            return response()->json();
        } catch (\Exception $exception) {
            throw $exception;
        }
    }

    /**
     * (Un)Follow a topic
     *
     * @param Forum $forum
     * @param Topic $topic
     * @throws \Exception
     */
    public function follow(Forum $forum, Topic $topic)
    {
        try {
            auth()->user()->toggleFollow($topic);
        } catch (\Exception $exception) {
            throw $exception;
        }
    }
}
