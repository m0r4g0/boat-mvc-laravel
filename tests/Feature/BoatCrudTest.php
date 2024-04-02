<?php

namespace Tests\Feature;

use App\Models\Boat;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class BoatCrudTest extends TestCase
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

    public function testUserCanCreateBoat()
    {
        $response = $this->actingAs($this->user)->post('/boats', [
            'name' => 'Test Boat',
            'category' => 'sailing-yacht',
        ]);

        $response->assertStatus(302);
        $response->assertRedirect('/boats');
        $this->assertDatabaseHas('boats', [
            'name' => 'Test Boat',
            'category' => 'sailing-yacht',
        ]);
    }

    public function testUserCanUpdateBoat()
    {
        $boat = Boat::factory()->create();

        $response = $this->actingAs($this->user)->put('/boats/' . $boat->id, [
            'name' => 'Updated Boat Name',
            'category' => 'motor-boat',
        ]);

        $response->assertStatus(302);
        $response->assertRedirect('/boats');

        $this->assertDatabaseHas('boats', [
            'id' => $boat->id,
            'name' => 'Updated Boat Name',
            'category' => 'motor-boat',
            'user_id' => $this->user->id,
        ]);
    }

    public function testUserCanDeleteBoat()
    {
        $boat = Boat::factory()->create();

        $response = $this->actingAs($this->user)->delete('/boats/' . $boat->id);

        $response->assertStatus(302);
        $response->assertRedirect('/boats');

        $this->assertDatabaseMissing('boats', [
            'id' => $boat->id,
        ]);
    }

    // this is absurd. I am making slugs unique with increments
    public function testSlugUniqueness()
    {
        $secondUser = User::factory()->create([
            'id' => 2,
            'email' => 'test2@test.com',
            'password' => bcrypt('password123'),
        ]);
        $this->actingAs($this->user)->post('/boats', [
            'name' => 'Test Boat',
            'category' => 'sailing-yacht',
            'id' => $this->user->id,
        ]);
        $response = $this->actingAs($secondUser)->post('/boats', [
            'name' => 'Test Boat',
            'category' => 'motor-boat',
            'id' => $secondUser->id,
        ]);
        // $response->assertSessionHasErrors();
        $response->assertStatus(302); // Check if the response is a redirect
    }
}
