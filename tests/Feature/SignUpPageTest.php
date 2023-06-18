<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SignUpPageTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testSignUpPageStatus()
    {
        $response = $this->get('/signup');

        $response->assertStatus(200);
    }

    public function testNewUserRegistering()
    {
        $response = $this->withoutMiddleware()->post('/signup', [
            'lastname' => 'testLastname',
            'firstname' => 'testFirstname',
            'patronymic' => 'testPatronymic',
            'email' => 'test@email.com',
            'password' => 'testPassword'
        ]);
        $response->assertStatus(302);
        $this->assertDatabaseHas('users', ['email' => 'test@email.com']);
    }
}
