<?php

namespace Modules\Forum\Controllers;

use Modules\Forum\Models\Forum;
use Modules\Forum\Models\Post;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Kalnoy\Nestedset\Collection;
use App\Http\Controllers\Controller;

class ForumController extends Controller
{
    use ValidatesRequests;

    /**
     * Get all main forums
     *
     * @return mixed
     */
    public function index()
    {
        return Forum::where("parent_id", null)
            ->with("children", "children.last", "children.last.topic", "children.last.author")
            ->get();
    }

    /**
     * Show a forum with direct children, last post and last post topic
     *
     * @param Forum $forum
     * @return Forum
     */
    public function show(Forum $forum)
    {
        $forum->load("children", "children.last", "children.last.topic", "children.last.author");
        return $forum;
    }

    /**
     * Store a forum
     *
     * @return mixed
     * @throws \Exception
     */
    public function store()
    {
        try {
            $data = request()->only(['name', "content"]);

            $parent = (request()->only("parent_id")) ? request()->only("parent_id")['parent_id'] : null;
            $parent = Forum::find($parent);

            $forum = Forum::create($data);

            if($parent) {
                $forum->parent_id = $parent->id;
                $forum->save();
            }

            return $forum;
        } catch (\Exception $exception) {
            throw $exception;
        }
    }

    /**
     * Update a forum
     *
     * @param Forum $forum
     * @return Forum
     * @throws \Exception
     */
    public function update(Forum $forum)
    {
        $data = request()->only(['name', "content"]);

        $parent = (request()->only("parent_id")) ? request()->only("parent_id")['parent_id'] : null;
        if($parent) $newParent = Forum::findOrFail($parent);

        // Check if forum has to move AND has post
        $hasMoved = ($newParent && ($newParent->id !== $forum->parent_id));
        $hasPostsAndMoved = ($hasMoved && $forum->last_post);

        try {
            $forum->update($data);

            // Check ancestors last post then
            if($hasPostsAndMoved) {
                $newAncestors = $newParent->getAncestors();
                $newAncestors->prepend($newParent);

                $this->setAncestorsLastPost($newAncestors, $forum->lastPost);
                unset($newAncestors, $newParent);

                $ancestors = $forum->getAncestors();
                $this->setAncestorsLastPost($ancestors, $forum->lastPost);
            }

            return $forum;
        } catch (\Exception $exception) {
            throw $exception;
        }
    }

    /**
     * Delete a forum
     *
     * Cascade is handled by the forum Model
     *
     * @param Forum $forum
     * @throws \Exception
     */
    public function destroy(Forum $forum)
    {
        try {
            $forum->delete();
        } catch (\Exception $exception) {
            throw $exception;
        }
    }

    /**
     * Set last post to ancestors correctly
     *
     * - If no post is given, we seek lastPost for the deepest forum as last post
     * - From deepest forum to the highest, if last post is newer, it replaces last post
     * - It last post is no strictly newer than actual last post, this process stops
     *
     * @param Collection $ancestors
     * @param Post $lastPost
     */
    private function setAncestorsLastPost(Collection $ancestors, Post $lastPost = null)
    {
        foreach ($ancestors as $ancestor) {
            // if ancestor last post is newer, then we stop
            if($lastPost && $ancestor->lastPost) {
                if(($ancestor->lastPost->id > $lastPost->id)) break;
            }
            // if we have not break yet, we evaluate last post
            $ancestor->evaluateLastPost();
        }
    }
}
