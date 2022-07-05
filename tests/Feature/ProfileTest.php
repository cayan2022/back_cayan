<?php

use App\Models\Country;
use App\Models\User;
use Illuminate\Http\Testing\File;

it('can view profile if authenticated', function () {
    $this->getJson(route('dashboard.profile.show'))->assertUnauthorized();

    $user = User::factory()->create();
    actingAs($user)
        ->getJson(route('dashboard.profile.show'))
        ->assertSuccessful()
        ->assertJson(['data' => $user->getResource()->jsonSerialize()]);
});

it('is unauthenticated', function () {
    $this->postJson(route('dashboard.profile.logout'))->assertUnauthorized();

    actingAs(User::factory()->create())
        ->postJson(route('dashboard.profile.logout'))
        ->assertSuccessful()
        ->assertJson(['message' => __('auth.logged_out')]);
});

it('can\'t update profile', function () {
    $this->postJson(route('dashboard.profile.update'))->assertUnauthorized();
});

it('can update profile', function () {
    $oldUserData = ['name' => 'test', 'gender' => User::MALE, 'email' => 'test@test.com'];
    $user = User::factory()->create($oldUserData);

    actingAs($user)
        ->postJson(route('dashboard.profile.update'), [
            'name' => $user->name,
            'gender' => $user->gender,
            'email' => 'ss@ss.com',
            'country_id' => Country::inRandomOrder()->take(1)->first()->id,
            'phone' => '999999999',
            'password' => '123456789',
            'password_confirmation' => '123456789',
            'image' => File::image('test.jpg'),
        ])->assertSuccessful()
        ->assertJson(['data' => $user->getResource()->jsonSerialize()]);
    $this->assertFileExists($user->getFirstMedia('images')->getPath());

    expect([$oldUserData['name'], $oldUserData['gender']])
        ->toMatchArray([$user->name, $user->gender])
        ->toBeTruthy()
        ->and($user->getResource()->jsonSerialize()['image'])
        ->toEqual($user->getAvatar())
        ->and($oldUserData['email'])
        ->not
        ->toEqual($user->email);
});
