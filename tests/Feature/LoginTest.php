<?php

namespace Tests\Feature;

use Database\Seeders\DatabaseSeeder;
use Database\Seeders\RolesAndPermissionsSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;


class LoginTest extends TestCase
{



    public function test_login_validation()
    {
        $this->postJson(route('auth.login'), [])
            ->assertJsonValidationErrors(['username', 'password']);

        $this->postJson(route('auth.login'), [
            'username' => 'ssssN',
            'password' => 'password',
        ])
            ->assertStatus(403);
    }

    public function test_sanctum_login()
    {
        $user = User::factory()->create();

        $response = $this->postJson(route('auth.login'), [
            'username' => $user->email,
            'password' => 'password',
        ]);

        $response->assertSuccessful()
            ->assertJson([
                'data' => $user->getResource()->jsonSerialize(),
            ])
            ->assertJsonStructure(['token']);

    }
}
