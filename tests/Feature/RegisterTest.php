<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;


class RegisterTest extends TestCase
{

    public function test_employee_register_validation()
    {
        $this->postJson(route('auth.register'), [])
            ->assertJsonValidationErrors(['name', 'email','country_id', 'phone', 'password']);

        $this->postJson(route('auth.register'), [
            'name' => 'User',
            'email' => 'user.demo.com5',
            'country_id' => '1',
            'phone' => '123456',
            'type' => User::MODERATOR,
            'password' => 'password',
            'password_confirmation' => '123456',
        ])
            ->assertJsonValidationErrors(['email', 'password']);
    }

    function test_employee_register()
    {
        $response = $this->postJson(route('auth.register'), [
            'name' => 'User Test',
            'email' => 'user@demo.com',
            'country_id' => '1',
            'phone' => '123456',
            'password' => 'password',
            'type' => User::MODERATOR,
            'gender' => User::MALE,
            'password_confirmation' => 'password',
        ]);

        $response->assertSuccessful()
            ->assertJsonStructure(['token']);
    }
}
