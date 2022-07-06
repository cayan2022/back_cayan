<?php

use App\Models\Country;
use App\Models\User;
use Illuminate\Http\Testing\File;
use Illuminate\Support\Arr;

beforeEach(fn () => $this->user=User::factory()->create());

it('can view profile if authenticated', function () {
    $this->getJson(route('dashboard.profile.show',$this->user))->assertUnauthorized();

    actingAs($this->user)
        ->getJson(route('dashboard.profile.show',$this->user))
        ->assertSuccessful()
        ->assertJson(['data' => $this->user->getResource()->jsonSerialize()]);
});

it('is unauthenticated', function () {
    $this->postJson(route('dashboard.profile.logout',$this->user))->assertUnauthorized();

    actingAs($this->user)
        ->postJson(route('dashboard.profile.logout',$this->user))
        ->assertSuccessful()
        ->assertJson(['message' => __('auth.logged_out')]);
});

it('can\'t update profile', function () {
    $this->putJson(route('dashboard.profile.update',$this->user))->assertUnauthorized();
});

it('can update profile', function () {
    $oldUserData = ['name' => 'test', 'gender' => User::MALE, 'email' => 'test@test.com'];
    $this->user = User::factory()->create($oldUserData);

    actingAs($this->user)
        ->putJson(route('dashboard.profile.update',$this->user), [
            'name' => $this->user->name,
            'gender' => $this->user->gender,
            'email' => 'ss@ss.com',
            'country_id' => Country::inRandomOrder()->take(1)->first()->id,
            'phone' => '999999999',
            'password' => '123456789',
            'password_confirmation' => '123456789',
            'image' => File::image('test.jpg'),
        ])->assertSuccessful()
        ->assertExactJson(['data' => $this->user->fresh()->getResource()->jsonSerialize()]);
    $this->assertFileExists($this->user->getFirstMedia('images')->getPath());

    expect([$oldUserData['name'], $oldUserData['gender']])
        ->toMatchArray([$this->user->name, $this->user->gender])
        ->toBeTruthy()
        ->and($this->user->fresh()->getResource()->jsonSerialize()['image'])
        ->toEqual($this->user->getAvatar())
        ->and($oldUserData['email'])
        ->not
        ->toEqual($this->user->fresh()->email);
});
test('image validation during updating profile', function () {
    $updatedData=[
        'name' => $this->user->name,
        'gender' => $this->user->gender,
        'email' => 'ss@ss.com',
        'country_id' => Country::inRandomOrder()->take(1)->first()->id,
        'phone' => '999999999',
        'password' => '123456789',
        'password_confirmation' => '123456789',
        'image'=>'text'
    ];
    actingAs($this->user)
        ->putJson(route('dashboard.profile.update',$this->user),$updatedData )
        ->assertJsonValidationErrorFor('image');

    actingAs($this->user)
        ->putJson(route('dashboard.profile.update',$this->user),Arr::set($updatedData, 'image', null))
        ->assertSuccessful()
        ->assertJsonMissingValidationErrors('image');
});
