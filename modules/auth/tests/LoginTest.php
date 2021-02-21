<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class LoginTest extends TestCase
{
    use RefreshDatabase;
    use DatabaseMigrations;

    private $user;

    public function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->create();
    }

    /**
     * Checks if login succeeds
     *
     * @return void
     * @test
     */
    public function canBeSuccessful()
    {
        $response = $this->post('/auth/login', ["email" => $this->user->email, "password" => "password"]);

        $response->assertSuccessful();
    }

    /**
     * @test
     */
    public function failsWhenFalseEmail()
    {
        $response = $this->post('/auth/login', ["email" => "bibi@grogu.net", "password" => "password"]);

        $response->assertStatus(401);
    }

    /**
     * @test
     */
    public function failsWhenFalsePassword()
    {
        $response = $this->post('/auth/login', ["email" => $this->user->email, "password" => "fake"]);

        $response->assertStatus(401);
    }
}
