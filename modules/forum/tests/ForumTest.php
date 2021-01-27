<?php

namespace Modules\Forum\Tests;

use App\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Modules\Forum\Models\Forum;
use Modules\Forum\Models\Topic;
use Modules\Personnages\Models\Personnage;
use Tests\TestCase;

class ForumTest extends TestCase
{
    use DatabaseMigrations;

    private $forum;
    private $forum_topic;
    private $author;
    private $user;

    public function setUp()
    {
        parent::setUp();

        $this->forum = factory(Forum::class)->create();
        $this->user = factory(User::class)->create();
        /*$this->author = factory(Personnage::class)->create([
            "owner_id" => $this->user->id
        ]);
        $this->forum_topic = factory(Topic::class)->create([
            "author" => $this->author->id,
            "forum_id" => $this->forum->id
        ]);*/
    }

    /**
     * @test
     */
    public function it_stores_a_forum()
    {
        $response = $this->post("api/forums", [
            "name" => "small forum",
            "content" => "",
            "parent_id" => null
        ]);

        $response->assertSuccessful();

        $this->assertDatabaseHas("forums", [
            "name" => "small forum",
            "slug" => "small-forum",
            "content" => null,
            "parent_id" => null
        ]);
    }

    public function it_updates_a_forum()
    {

    }

    public function it_throws_exception_if_not_valid()
    {

    }

    /**
     * @test
     */
    public function it_destroys_forum_softly()
    {
        $response = $this->delete("api/forums/".$this->forum->id);
        $response->assertSuccessful();
        $this->assertSoftDeleted("forums", ["id" => $this->forum->id]);
    }

    /**
     * @todo
     */
    public function it_destroys_child_topics_when_deleted()
    {
        $this->delete("api/forums/".$this->forum->id);
        $this->assertSoftDeleted("topics", ["id" => $this->forum_topic->id]);
    }

    public function it_destroys_child_forums_when_deleted()
    {
        
    }

    public function non_admin_cannot_use_forum_api()
    {

    }
}