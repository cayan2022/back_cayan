<?php

namespace Tests\Feature;

use Illuminate\Http\UploadedFile;
use Tests\TestCase;
use App\Models\User;


class StoreProfileTest extends TestCase
{

    public function test_store_profile_validation()
    {
        $this->postJson(route('dashboard.profile.store'), [])
            ->assertJsonValidationErrors(['name', 'email','country_id', 'phone', 'password']);

        $this->postJson(route('dashboard.profile.store'), [
            'name' => 'User',
            'email' => 'user.demo.com5',
            'country_id' => '1',
            'phone' => '123456',
            'type' => User::MODERATOR,
            'image' => UploadedFile::fake()->create('file.pdf'),
            'password' => 'password',
            'password_confirmation' => '123456',
        ])
            ->assertJsonValidationErrors(['email', 'password','image']);
    }

    function test_store_profile()
    {
        $response = $this->postJson(route('dashboard.profile.store'), [
            'name' => 'User Test',
            'email' => 'user@demo.com',
            'country_id' => '1',
            'phone' => '123456',
            'password' => 'password',
            'type' => User::MODERATOR,
            'gender' => User::MALE,
            'image' => UploadedFile::fake()->image('avatar.jpg'),
            'password_confirmation' => 'password',
        ]);

        $response->assertSuccessful()
            ->assertJsonStructure(['token']);
        $this->assertFileExists(User::find($response['data']['id'])->getFirstMedia('images')->getPath());
    }
}
