<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class FavoriteFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'id_usuario' => $this->faker->numberBetween($min = 1, $max = 10),
            'ref_api' => $this->faker->text
        ];
    }
}


