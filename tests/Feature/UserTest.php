<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;

class UserTest extends TestCase
{
    use WithFaker;

    public function test_edit_user()
    {
        $this->withoutExceptionHandling();
        $user = User::first();
        $response = $this->actingAs($user, 'sanctum')->get(route('user_edit', 1))->assertStatus(200);

    }

    public function test_update_user()
    {
        $this->withoutExceptionHandling();
        $user = User::first();
        $text = $this->faker->text;
        $response = $this->actingAs($user, 'sanctum')->patch(route('user_update', $user->id), [
            '_token' => csrf_token(),
            'name' => $user->name,
            'email' => $user->email,
            'address' => $this->faker->address,
            'birthdate' => $this->faker->dateTimeThisCentury->format('Y-m-d'),
            'city' => $this->faker->city

        ])->assertStatus(200);

        $this->assertDatabaseHas('users', [
            'name' => $user->name,
            'email' => $user->email
        ]);

    }
}
