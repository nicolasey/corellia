<?php
namespace Modules\Forum\Tests;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Modules\Forum\Models\Forum;
use Modules\Forum\Models\Post;
use Modules\Forum\Models\Topic;
use Tests\TestCase;

class LastPostTest extends TestCase
{
    use DatabaseMigrations;

    private $oldForum;
    private $newForum;
    private $flyingForum;
    private $flyingTopic;
    private $topic;
    private $message;

    public function setUp()
    {
        parent::setUp();

        $this->oldForum = factory(Forum::class)->create();
        $this->newForum = factory(Forum::class)->create();
        $this->flyingForum = factory(Forum::class)->create(['parent_id' => $this->oldForum->id]);
        $this->flyingtopic = factory(Topic::class)->create(['forum_id' => $this->flyingForum->id]);
        $this->message = factory(Post::class)->create(['topic_id' => $this->flyingTopic->id]);
    }

    /**
     * @test
     */
    public function it_evaluates_new_last()
    {
        $response = $this->put("api/forums/".$this->flyingForum->id, [
            "name" => "evaluation",
            "content" => "test thing",
            "parent_id" => $this->newForum->id
        ]);

        $response->assertSuccessful();
    }
}