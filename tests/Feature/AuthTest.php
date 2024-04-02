<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use App\Models\Boat;


class AuthTest extends TestCase
{
    use RefreshDatabase;

    public function testUserCanLoginWithCorrectCredentials()
    {
        $user = User::factory()->create([
            'email' => 'test@example.com',
            'password' => bcrypt('password123'),
        ]);

        $response = $this->post('/api/login', [
            'email' => 'test@example.com',
            'password' => 'password123',
        ]);

        $response->assertRedirect('/boats');
        $this->assertAuthenticatedAs($user);
    }

    public function testUserCannotLoginWithIncorrectCredentials()
    {
        $user = User::factory()->create([
            'email' => 'test@example.com',
            'password' => bcrypt('password123'),
        ]);

        $response = $this->post('/api/login', [
            'email' => 'test@example.com',
            'password' => 'wrongpassword',
        ]);

        $response->assertStatus(302);
        $response->assertRedirect('/login');
        $this->assertGuest();
    }

    public function testGuestCannotAccessBoatCreationPage()
    {
        $response = $this->get('/boats/create');

        $response->assertRedirect('/login');
    }

    public function testAuthenticatedUserCanAccessBoatCreationPage()
    {
        $user = User::factory()->create([
            'email' => 'test@example.com',
            'password' => bcrypt('password123'),
        ]);

        $response = $this->actingAs($user)->get('/boats/create');

        $response->assertStatus(200);
    }

    public function testUserCanEditOwnBoat()
    {
        $user =  User::factory()->create([
            'email' => 'test@example.com',
            'password' => bcrypt('password123'),
        ]);

        $boat = Boat::factory()->create(['user_id' => $user->id]);

        $response = $this->actingAs($user)->get("/boats/{$boat->id}/edit");

        $response->assertStatus(200);
    }

    public function testUserCannotEditOtherUsersBoat()
    {
        $user =  User::factory()->create([
            'email' => 'test@example.com',
            'password' => bcrypt('password123'),
        ]);

        $secondUser =  User::factory()->create([
            'id' => 2,
            'email' => 'test2@test.com',
            'password' => bcrypt('123456'),
        ]);

        $boat = Boat::factory()->create([
            'name' => 'Test Boat',
            'category' => 'sailing-yacht',
            'user_id' => $user->id
        ]);

        $response = $this->actingAs($secondUser)->get("/boats/{$boat->id}/edit");

        $response->assertStatus(302);
    }
}