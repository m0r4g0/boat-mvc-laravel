<?php

namespace Tests\Feature;

use App\Models\Boat;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class BoatIdOrSlugTest extends TestCase
{
    use RefreshDatabase;

    protected $user;

    protected function setUp(): void
    {
        parent::setUp();

        // Creating a test user for authentication
        $this->user = User::factory()->create([
            'email' => 'test@example.com',
            'password' => bcrypt('password123'),
        ]);
    }

    public function testDisplayBoatWithId()
    {
        $boat = Boat::factory()->create();

        $response = $this->get("/boats/{$boat->id}");

        $response->assertStatus(200)
            ->assertSee($boat->name);
    }

    public function testDisplayBoatWithSlug()
    {
        $boat = Boat::factory()->create();

        $response = $this->get("/boats/{$boat->slug}");

        $response->assertStatus(200)
            ->assertSee($boat->name);
    }
}
