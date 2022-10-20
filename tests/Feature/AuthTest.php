<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;

class AuthTest extends TestCase
{
   use WithFaker;

    public function test_login_displays_validation_errors()
    {
        $response = $this->post(route('login'), []);
        $response->assertStatus(401);

    }

    public function test_login_authenticates()
    {
        $this->withoutExceptionHandling();

        $user = User::first();
        $response = $this->post(route('login'), [
            '_token' => csrf_token(),
            'email' => $user->email,
            'password' => 'password'
        ])->assertStatus(200);

    }

    public function test_register_creates_and_authenticates_a_user()
    {

        $this->withoutExceptionHandling();

        $name = $this->faker->name;
        $email = $this->faker->email;
        $password = $this->faker->numberBetween($min = 10000000, $max = 90000000);
        $address = $this->faker->address;
        $birthdate = $this->faker->dateTimeThisCentury->format('Y-m-d');
        $city = $this->faker->city;

        $response = $this->post(route('register'), [
            'name' => $name,
            'email' => $email,
            'password' => $password,
            'password_confirmation' => $password,
            'address' => $address,
            'birthdate' => $birthdate,
            'city' => $city

        ])->assertStatus(200);

        $this->assertDatabaseHas('users', [
            'name' => $name,
            'email' => $email,
            'address' => $address,
            'birthdate' => $birthdate,
            'city' => $city
        ]);

    }
}
