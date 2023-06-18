<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class SignInPageTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testSignInPageStatus()
    {
        $response = $this->get('/signin');

        $response->assertStatus(200);
    }

    public function testAuthenticate()
    {
        $user = User::factory()->create();

        $response = $this->withoutMiddleware()->post('/signin', [
            'email' => $user->email,
            'password' => 'testpass',
        ]);

        $response->assertStatus(302);
        $this->assertAuthenticatedAs($user); // Check if the user is authenticated
    }
}
