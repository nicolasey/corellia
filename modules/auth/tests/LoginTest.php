<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class LoginTest extends TestCase
{
    use RefreshDatabase, DatabaseMigrations;

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
    public function can_be_successful()
    {
        $response = $this->post('/auth/login', ["email" => $this->user->email, "password" => "password"]);

        $response->assertSuccessful();
    }

    /**
     * @test
     */
    public function fails_when_false_email()
    {
        $response = $this->post('/auth/login', ["email" => "bibi@grogu.net", "password" => "password"]);

        $response->assertStatus(401);
    }

    /**
     * @test
     */
    public function fails_when_false_password()
    {
        $response = $this->post('/auth/login', ["email" => $this->user->email, "password" => "fake"]);

        $response->assertStatus(401);
    }
}
